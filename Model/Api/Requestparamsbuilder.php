<?php

class ICT_Klar_Model_Api_Requestparamsbuilder
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
}