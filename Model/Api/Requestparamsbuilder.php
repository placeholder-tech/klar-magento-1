<?php

class Klar_DataSync_Model_Api_Requestparamsbuilder extends Klar_DataSync_Model_Abstractapirequestparamsbuilder
{
    const EMPTY_VALUE = '-';
    const FINANCIAL_STATUS_PENDING = 'pending';
    const FINANCIAL_STATUS_PAID = 'paid';
    const FINANCIAL_STATUS_PARTIALLY_PAID = 'partially_paid';
    const FINANCIAL_STATUS_REFUNDED = 'refunded';
    const FINANCIAL_STATUS_PARTIALLY_REFUNDED = 'partially_refunded';
    const SHIPMENT_STATUS_NOT_SHIPPED = 'not_shipped';
    const SHIPMENT_STATUS_SHIPPED = 'shipped';
    const SHIPMENT_STATUS_PARTIALLY_SHIPPED = 'partially_shipped';
    const SHIPMENT_CREATED_AT_FIELD = 'created_at';
    const SHIPMENT_TOTAL_QTY_FIELD = 'total_qty';

    /**
     * Build params array from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(Mage_Sales_Model_Order $salesOrder)
    {
        /* @var Klar_DataSync_Model_Data_Order $order */
        $order = Mage::getModel('klar_datasync/data_order');
        $processedAt = $this->getProcessedAt($salesOrder);

        $order->setId($salesOrder->getId());
        $order->setCreatedAt($this->getTimestamp($salesOrder->getCreatedAt()));
        $order->setUpdatedAt($this->getTimestamp($salesOrder->getUpdatedAt()));

        if ($processedAt) {
            $order->setProcessedAt($processedAt);
        }

        $order->setClosedAt($this->getClosedAt($salesOrder));
        $order->setCancelledAt($this->getCancelledAt($salesOrder));
        $order->setCurrencyCodeIso3Letter($salesOrder->getOrderCurrencyCode());
        $order->setFinancialStatus($this->getFinancialStatus($salesOrder));
        $order->setShipmentStatus($this->getShipmentStatus($salesOrder));
        $order->setPaymentGatewayName($salesOrder->getPayment()->getMethod());
        
        if ($salesOrder->getPayment()->getAdditionalInformation('method_title')) {
            $order->setPaymentMethodName(
                $salesOrder->getPayment()->getAdditionalInformation('method_title')
            );
        } else {
            $order->setPaymentMethodName(self::EMPTY_VALUE);
        }
        
        $order->setOrderName($this->getOrderName($salesOrder));
        $order->setOrderNumber($salesOrder->getIncrementId());
        
        $order->setLineItems(
            Mage::getSingleton('klar_datasync/builder_lineitemsbuilder')->buildFromSalesOrder($salesOrder)
        );
        
        $order->setRefundedLineItems(
            Mage::getSingleton('klar_datasync/builder_refundedlineitemsbuilder')->buildFromSalesOrder($salesOrder)
        );
        
        $order->setShipping(
            Mage::getSingleton('klar_datasync/builder_shippingbuilder')->buildFromSalesOrder($salesOrder)
        );
        
        $order->setCustomer(
            Mage::getSingleton('klar_datasync/builder_customerbuilder')->buildFromSalesOrder($salesOrder)
        );
        
        $order->setOptionalIdentifiers(
            Mage::getSingleton('klar_datasync/builder_optionalidentifiersbuilder')->buildFromSalesOrder($salesOrder)
        );

        return $this->snakeToCamel($order->toArray());
    }

    /**
     * Get sales order processed at timestamp.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return false|int
     */
    private function getProcessedAt(Mage_Sales_Model_Order $salesOrder)
    {
        $processedAt = false;

        if ($salesOrder->hasShipments()) {
            /* @var ShipmentModel $firstShipment */
            $firstShipment = $salesOrder->getShipmentsCollection()
                ->addFieldToSelect(self::SHIPMENT_CREATED_AT_FIELD)
                ->getFirstItem();

            if ($firstShipment->getId()) {
                $processedAt = $this->getTimestamp($firstShipment->getUpdatedAt());
            }
        }

        return $processedAt;
    }

    /**
     * Get sales order closed at timestamp.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return int
     */
    private function getClosedAt(Mage_Sales_Model_Order $salesOrder)
    {
        $closedAt = 0;

        foreach ($salesOrder->getAllStatusHistory() as $orderComment) {
            if ($orderComment->getStatus() === Mage_Sales_Model_Order::STATE_CLOSED) {
                $closedAt = $this->getTimestamp($orderComment->getCreatedAt());
            }
        }

        return $closedAt;
    }

    /**
     * Get sales order cancelled at.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return int
     */
    private function getCancelledAt(Mage_Sales_Model_Order $salesOrder)
    {
        $cancelledAt = 0;

        if ($salesOrder->getStatus() === Mage_Sales_Model_Order::STATE_CANCELED) {
            $cancelledAt = $this->getTimestamp($salesOrder->getUpdatedAt());
        }

        return $cancelledAt;
    }

    /**
     * Get sales order financial status.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return string
     */
    private function getFinancialStatus(Mage_Sales_Model_Order $salesOrder)
    {
        $financialStatus = self::FINANCIAL_STATUS_PENDING;
        $totalPaid = (float)$salesOrder->getTotalPaid();
        $totalRefunded = (float)$salesOrder->getTotalRefunded();
        $grandTotal = $salesOrder->getGrandTotal();

        if ($totalPaid >= $grandTotal) {
            $financialStatus = self::FINANCIAL_STATUS_PAID;
        }

        if ($totalPaid > 0 && $totalPaid < $grandTotal) {
            $financialStatus = self::FINANCIAL_STATUS_PARTIALLY_PAID;
        }

        if ($totalRefunded >= $grandTotal) {
            $financialStatus = self::FINANCIAL_STATUS_REFUNDED;
        }

        if ($totalRefunded > 0 && $totalRefunded < $grandTotal) {
            $financialStatus = self::FINANCIAL_STATUS_PARTIALLY_REFUNDED;
        }

        return $financialStatus;
    }

    /**
     * Get sales order shipment status.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return string
     */
    private function getShipmentStatus(Mage_Sales_Model_Order $salesOrder)
    {
        $shipmentStatus = self::SHIPMENT_STATUS_NOT_SHIPPED;

        if ($salesOrder->hasShipments()) {
            $qtyOrdered = (float)$salesOrder->getTotalQtyOrdered();
            $qtyShipped = 0;

            $shipments = $salesOrder->getShipmentsCollection()
                ->addFieldToSelect(self::SHIPMENT_TOTAL_QTY_FIELD)
                ->getItems();

            /* @var Mage_Sales_Model_Order_Shipment $shipment */
            foreach ($shipments as $shipment) {
                if ($shipment->getId()) {
                    $qtyShipped += (float)$shipment->getTotalQty();
                }
            }

            if ($qtyShipped < $qtyOrdered) {
                $shipmentStatus = self::SHIPMENT_STATUS_PARTIALLY_SHIPPED;
            } else {
                $shipmentStatus = self::SHIPMENT_STATUS_SHIPPED;
            }
        }

        return $shipmentStatus;
    }

    /**
     * Get order name.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return string
     */
    private function getOrderName(Mage_Sales_Model_Order $salesOrder)
    {
        $orderName = self::EMPTY_VALUE;
        try {
            $storeName = Mage::app()->getStore($salesOrder->getStoreId())->getName();
            $orderName = $storeName . ' - Order #' . $salesOrder->getIncrementId();
        } catch (Mage_Core_Exception $e) {
            return $orderName;
        }

        return $orderName;
    }

    /**
     * Get optional identifiers.
     *
     * @return Klar_DataSync_Model_Data_Optionalidentifiers
     */
    private function getOptionalIdentifiers()
    {
        return Mage::getModel('klar_datasync/data_optionalidentifiers');
    }
}