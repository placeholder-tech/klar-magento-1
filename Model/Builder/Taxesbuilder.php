<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Taxesbuilder extends CodeApp_Klar_Model_Abstracatpirequestparamsbuilder
{
    const TAXABLE_ITEM_TYPE_PRODUCT = 'product';
    const TAXABLE_ITEM_TYPE_SHIPPING = 'shipping';

    /**
     * Get taxes from sales order by type.
     *
     * @param int $salesOrderId
     * @param OrderItemInterface|null $salesOrderItem
     * @param string $taxableItemType
     *
     * @return array
     */
    public function build(
        $salesOrderId,
        Mage_Sales_Model_Order_Item $salesOrderItem = null,
        $taxableItemType = self::TAXABLE_ITEM_TYPE_PRODUCT
    ) {
        $taxes = [];
        $taxItems = Mage::getResourceModel('tax/sales_order_tax')
                        ->getCollection()->addFieldToFilter('order_id', $salesOrderId); // TODO I need and order instead order_id, maybe change this to some other model / resource model

        foreach ($taxItems as $taxItem) {
            $taxRate = (float)($taxItem['tax_percent'] / 100);

            if ($taxItem['taxable_item_type'] === self::TAXABLE_ITEM_TYPE_PRODUCT &&
                $salesOrderItem !== null) {
                $salesOrderItemId = (int)$salesOrderItem->getId();

                if ((int)$taxItem['item_id'] !== $salesOrderItemId) {
                    continue;
                }

                $qty = $salesOrderItem->getQtyOrdered() ? $salesOrderItem->getQtyOrdered() : 1;
                $itemPrice = (float)$salesOrderItem->getPriceInclTax() - ((float)$salesOrderItem->getDiscountAmount() / $qty); // TODO implement discount service to get discount amount
                //$itemPrice = (float)$salesOrderItem->getOriginalPrice() - ((float)$salesOrderItem->getDiscountAmount() / $qty);
                $taxAmount = $itemPrice - ($itemPrice / (1+ $taxRate));
            } else {
                $taxAmount = (float)$taxItem['real_amount'];
            }

            if ($taxItem['taxable_item_type'] === $taxableItemType) {
                /* @var CodeApp_Klar_Model_Data_Tax $tax */
                $tax = Mage::getModel('codeapp_klar/data_tax');

                $tax->setTitle($taxItem['title']);
                $tax->setTaxRate($taxRate);
                $tax->setTaxAmount($taxAmount);

                $taxes[$taxableItemType][] = $this->snakeToCamel($tax->toArray());
            }
        }

        if (!empty($taxes)) {
            return $taxes[$taxableItemType];
        }

        return $taxes;
    }
}
