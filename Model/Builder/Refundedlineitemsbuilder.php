<?php

class Klar_DataSync_Model_Builder_Refundedlineitemsbuilder extends Klar_DataSync_Model_Abstractapirequestparamsbuilder
{
    /**
     * Build refunded line items array from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(Mage_Sales_Model_Order $salesOrder)
    {
        $refundedLineItems = [];

        foreach ($salesOrder->getItemsCollection() as $salesOrderItem) {
            if (!(float)$salesOrderItem->getQtyRefunded()) {
                continue;
            }

            /* @var Klar_DataSync_Model_Data_Refundedlineitem $refundedLineItem */
            $refundedLineItem = Mage::getModel('klar_datasync/data_refundedlineitem');

            $refundedLineItem->setId((string)$salesOrderItem->getId());
            $refundedLineItem->setLineItemId((string)$salesOrderItem->getId());
            $refundedLineItem->setRefundedQuantity((float)$salesOrderItem->getQtyRefunded());
            $refundedLineItem->setCreatedAt($this->getTimestamp($salesOrderItem->getUpdatedAt()));

            $refundedLineItems[] = $this->snakeToCamel($refundedLineItem->toArray());
        }

        return $refundedLineItems;
    }
}
