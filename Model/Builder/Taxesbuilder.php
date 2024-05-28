<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Taxesbuilder extends CodeApp_Klar_Model_Abstractapirequestparamsbuilder
{
    const TAXABLE_ITEM_TYPE_PRODUCT = 'product';
    const TAXABLE_ITEM_TYPE_SHIPPING = 'shipping';

    /**
     * Get taxes from sales order item
     *
     * @param Mage_Sales_Model_Order_Item $salesOrderItem
     * 
     * @return array
     */
    public function buildForOrderItem(
        Mage_Sales_Model_Order_Item $salesOrderItem
    ) {
        $taxes = [];
        $taxItems = Mage::getResourceModel('tax/sales_order_tax_item')->getTaxItemsByItemId((int)$salesOrderItem->getId());

        foreach ($taxItems as $taxItem) {
            $taxRate = (float)($taxItem['tax_percent'] / 100);
            
            $qty = $salesOrderItem->getQtyOrdered() ? $salesOrderItem->getQtyOrdered() : 1;
            $itemPrice = (float)$salesOrderItem->getPriceInclTax() - ((float)$salesOrderItem->getDiscountAmount() / $qty); // TODO implement discount service to get discount amount
            $taxAmount = $itemPrice - ($itemPrice / (1+ $taxRate));

            /* @var CodeApp_Klar_Model_Data_Tax $tax */
            $tax = Mage::getModel('codeapp_klar/data_tax');

            $tax->setTitle($taxItem['title']);
            $tax->setTaxRate($taxRate);
            $tax->setTaxAmount($taxAmount);

            $taxes[] = $this->snakeToCamel($tax->toArray());
        }

        return $taxes;
    }

    /**
     * Get taxes for shipping
     *
     * @param Mage_Sales_Model_Order $salesOrder
     * 
     * @return array
     */
    public function buildForShipping(Mage_Sales_Model_Order $salesOrder)
    {
        $taxes = [];

        $taxItems = Mage::getModel('tax/sales_order_tax')
                        ->getCollection()
                        ->loadByOrder($salesOrder);

        foreach ($taxItems as $taxItem) {
            
        }
        /* @var CodeApp_Klar_Model_Data_Tax $tax */
        $tax = Mage::getModel('codeapp_klar/data_tax');

        $tax->setTitle($taxItem->getTitle());
        $tax->setTaxRate($taxItem->getPercent());
        $tax->setTaxAmount($salesOrder->getShippingTaxAmount());

        return $taxes;
    }
}
