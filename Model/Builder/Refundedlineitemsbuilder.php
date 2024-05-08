<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Refundedlineitemsbuilder extends CodeApp_Klar_Model_Abstracatpirequestparamsbuilder
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

        foreach ($salesOrder->getItems() as $salesOrderItem) {
            if (!(float)$salesOrderItem->getQtyRefunded()) {
                continue;
            }

            /* @var CodeApp_Klar_Model_Data_Refundedlineitem $refundedLineItem */
            $refundedLineItem = Mage::getModel('codeapp_klar/data_refundedlineitem');

            $refundedLineItem->setId((string)$salesOrderItem->getId());
            $refundedLineItem->setLineItemId((string)$salesOrderItem->getId());
            $refundedLineItem->setRefundedQuantity((float)$salesOrderItem->getQtyRefunded());
            $refundedLineItem->setCreatedAt($this->getTimestamp($salesOrderItem->getUpdatedAt()));

            $refundedLineItems[] = $this->snakeToCamel($refundedLineItem->toArray());
        }

        return $refundedLineItems;
    }
}
