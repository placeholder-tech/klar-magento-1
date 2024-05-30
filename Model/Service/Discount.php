<?php

class Klar_DataSync_Model_Service_Discount
{   
    private $customDiscountColumns = [];

    /**
     * @param Mage_Sales_Model_Order_Item $salesOrderItem
     * 
     * @return float
     */
    public function getDiscountAmountFromOrderItem(Mage_Sales_Model_Order_Item $salesOrderItem)
    {
        $discount = (float) $salesOrderItem->getDiscountAmount();

        foreach ($this->customDiscountColumns as $discountColumn) {
            if ($salesOrderItem->getData($discountColumn) && $salesOrderItem->getData($discountColumn) > 0) {
                $discount += (float) $salesOrderItem->getData($discountColumn);
            }
        }

        return $discount;
    }
}