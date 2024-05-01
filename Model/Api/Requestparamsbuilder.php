<?php

class ICT_Klar_Model_Api_Requestparamsbuilder extends ICT_Klar_Model_Abstracatpirequestparamsbuilder
{
    /**
     * Build params array from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(Mage_Sales_Model_Order $salesOrder)
    {
        /* @var OrderInterface $order */
        $order = $this->orderFactory->create();
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
        $order->setPaymentMethodName(
            $salesOrder->getPayment()->getAdditionalInformation('method_title') ?? self::EMPTY_VALUE
        );
        $order->setOrderName($this->getOrderName($salesOrder));
        $order->setOrderNumber($salesOrder->getIncrementId());
        $order->setLineItems($this->lineItemsBuilder->buildFromSalesOrder($salesOrder));
        $order->setRefundedLineItems($this->refundedLineItemsBuilder->buildFromSalesOrder($salesOrder));
        $order->setShipping($this->shippingBuilder->buildFromSalesOrder($salesOrder));
        $order->setCustomer($this->customerBuilder->buildFromSalesOrder($salesOrder));
        $order->setOptionalIdentifiers($this->optionalIdentifiersBuilder->buildFromSalesOrder($salesOrder));

        return $this->snakeToCamel($order->toArray());
    }

    /**
     * Get sales order processed at timestamp.
     *
     * @param SalesOrderInterface $salesOrder
     *
     * @return false|int
     */
    private function getProcessedAt(SalesOrderInterface $salesOrder)
    {
        $processedAt = false;

        if ($salesOrder->hasShipments()) {
            /* @var ShipmentModel $firstShipment */
            $firstShipment = $salesOrder->getShipmentsCollection()
                ->addFieldToSelect(ShipmentInterface::CREATED_AT)
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
     * @param SalesOrderInterface $salesOrder
     *
     * @return int
     */
    private function getClosedAt(SalesOrderInterface $salesOrder): int
    {
        $closedAt = 0;

        foreach ($salesOrder->getAllStatusHistory() as $orderComment) {
            if ($orderComment->getStatus() === SalesOrderModel::STATE_CLOSED) {
                $closedAt = $this->getTimestamp($orderComment->getCreatedAt());
            }
        }

        return $closedAt;
    }

    /**
     * Get sales order cancelled at.
     *
     * @param SalesOrderInterface $salesOrder
     *
     * @return int
     */
    private function getCancelledAt(SalesOrderInterface $salesOrder): int
    {
        $cancelledAt = 0;

        if ($salesOrder->getStatus() === SalesOrderModel::STATE_CANCELED) {
            $cancelledAt = $this->getTimestamp($salesOrder->getUpdatedAt());
        }

        return $cancelledAt;
    }

    /**
     * Get sales order financial status.
     *
     * @param SalesOrderInterface $salesOrder
     *
     * @return string
     */
    private function getFinancialStatus(SalesOrderInterface $salesOrder): string
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
     * @param SalesOrderInterface $salesOrder
     *
     * @return string
     */
    private function getShipmentStatus(SalesOrderInterface $salesOrder): string
    {
        $shipmentStatus = self::SHIPMENT_STATUS_NOT_SHIPPED;

        if ($salesOrder->hasShipments()) {
            $qtyOrdered = (float)$salesOrder->getTotalQtyOrdered();
            $qtyShipped = 0;

            $shipments = $salesOrder->getShipmentsCollection()
                ->addFieldToSelect(ShipmentInterface::TOTAL_QTY)
                ->getItems();

            /* @var ShipmentModel $shipment */
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
     * @param SalesOrderInterface $salesOrder
     *
     * @return string
     */
    private function getOrderName(SalesOrderInterface $salesOrder): string
    {
        $orderName = self::EMPTY_VALUE;
        try {
            $storeName = $this->storeManager->getStore($salesOrder->getStoreId())->getName();
            $orderName = $storeName . ' - Order #' . $salesOrder->getIncrementId();
        } catch (NoSuchEntityException $e) {
            return $orderName;
        }

        return $orderName;
    }

    /**
     * Get optional identifiers.
     *
     * @return OptionalIdentifiersInterface
     */
    private function getOptionalIdentifiers(): OptionalIdentifiersInterface
    {
        return $this->optionalIdentifiersFactory->create();
    }
}