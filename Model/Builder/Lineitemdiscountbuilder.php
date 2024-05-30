<?php

class Klar_DataSync_Model_Builder_Lineitemdiscountbuilder extends Klar_DataSync_Model_Abstractapirequestparamsbuilder
{
    /**
     * Build line item discounts array from sales order item.
     *
     * @param Mage_Sales_Model_Order_Item $salesOrderItem
     *
     * @return array
     */
    public function buildFromSalesOrderItem(Mage_Sales_Model_Order_Item $salesOrderItem)
    {
        $discounts = [];
        $discountAmount = Mage::getSingleton('klar_datasync/service_discount')
                            ->getDiscountAmountFromOrderItem($salesOrderItem);
        $discountLeft = $discountAmount;

        if ($discountAmount && $salesOrderItem->getAppliedRuleIds()) {
            $ruleIds = explode(',', $salesOrderItem->getAppliedRuleIds());

            foreach ($ruleIds as $ruleId) {
                $discount = $this->buildRuleDiscount(
                    (int)$ruleId,
                    (float)$salesOrderItem->getPriceInclTax()
                );

                if (!empty($discount)) {
                    $discounts[] = $discount;
                    if (isset($discount['discountAmount'])) {
                        $discountLeft -= $salesOrderItem->getQtyOrdered() * $discount['discountAmount'];
                    }
                }
            }
        }

        if (round($discountLeft,2) > 0.02) {
            $discounts[] = $this->buildOtherDiscount($discountLeft / $salesOrderItem->getQtyOrdered());
        }

        $calculatedDiscounts = $this->sumCalculatedDiscounts($discounts);
        if ($calculatedDiscounts - $discountAmount > 0.02) { // case when calculated discount is bigger than actual
            $discounts = $this->rebuildDiscountsBasedOnFlatData($discounts, $discountAmount);
        }

        $price = round((float)$salesOrderItem->getPriceInclTax(),2);
        $originalPrice = round((float)$salesOrderItem->getOriginalPrice(),2);

        if ($price < $originalPrice) {
            $discounts[] = $this->buildSpecialPriceDiscount($price, $originalPrice);
        }

        return $discounts;
    }

    /**
     * Build discount array from sales rule.
     *
     * @param int $ruleId
     * @param float $baseItemPrice
     *
     * @return array
     */
    private function buildRuleDiscount($ruleId, $baseItemPrice)
    {
        try {
            /** @var Mage_SalesRule_Model_Rule $salesRule */
            $salesRule = Mage::getModel('salesrule/rule')->load($ruleId);
        } catch (Mage_Core_Exception $e) {
            // Rule doesn't exist, manual calculation is not possible.
            return [];
        }

        if (!(float)$salesRule->getDiscountAmount()) {
            return [];
        }

        /* @var Klar_DataSync_Model_Data_Discount $discount */
        $discount = Mage::getModel('klar_datasync/data_discount');

        $discount->setTitle($salesRule->getName());
        $discount->setDescriptor($salesRule->getDescription());

        if ((int) $salesRule->getCouponType() === (int) Mage_SalesRule_Model_Rule::COUPON_TYPE_SPECIFIC) {
            $coupon = Mage::getModel('salesrule/coupon')->loadPrimaryByRule($salesRule);
            $discount->setIsVoucher(true);
            if ($coupon) {
                $discount->setVoucherCode($coupon->getCode());
            }
        }

        if ($salesRule->getSimpleAction() === Mage_SalesRule_Model_Rule::BY_PERCENT_ACTION) {
            $discountPercent = $salesRule->getDiscountAmount() / 100;
            $discount->setDiscountAmount($baseItemPrice * $discountPercent);
        } elseif ($salesRule->getSimpleAction() === Mage_SalesRule_Model_Rule::BY_FIXED_ACTION) {
            $discount->setDiscountAmount((float)$salesRule->getDiscountAmount());
        } else {
            return []; // Disallow other action types
        }

        return $this->snakeToCamel($discount->toArray());
    }

    /**
     * Build discount array if there is some discount left after calculating them from core magento rules
     *
     * @param float $discountLeft
     *
     * @return array
     */
    private function buildOtherDiscount($discountLeft)
    {
        /* @var Klar_DataSync_Model_Data_Discount $discount */
        $discount = Mage::getModel('klar_datasync/data_discount');

        $discount->setTitle(Klar_DataSync_Model_Data_Discount::OTHER_DISCOUNT_TITLE);
        $discount->setDescriptor(Klar_DataSync_Model_Data_Discount::OTHER_DISCOUNT_DESCRIPTOR);
        $discount->setDiscountAmount($discountLeft);

        return $this->snakeToCamel($discount->toArray());
    }

    /**
     * Build discount array for special price.
     *
     * @param float $price
     * @param float $originalPrice
     *
     * @return array
     */
    private function buildSpecialPriceDiscount($price, $originalPrice)
    {
        /* @var Klar_DataSync_Model_Data_Discount $discount */
        $discount = Mage::getModel('klar_datasync/data_discount');

        $discount->setTitle(Klar_DataSync_Model_Data_Discount::SPECIAL_PRICE_DISCOUNT_TITLE);
        $discount->setDescriptor(Klar_DataSync_Model_Data_Discount::SPECIAL_PRICE_DISCOUNT_DESCRIPTOR);
        $discount->setDiscountAmount($originalPrice - $price);

        return $this->snakeToCamel($discount->toArray());
    }

    private function sumCalculatedDiscounts(array $discounts)
    {
        $calculatedDiscounts = 0.00;
        foreach ($discounts as $discount) {
            $calculatedDiscounts += isset($discount['discountAmount']) ? $discount['discountAmount'] : 0.00;
        }

        return round($calculatedDiscounts, 2);
    }

    private function rebuildDiscountsBasedOnFlatData(array $discounts, $discountAmount)
    {
        $newDiscounts = [];
        foreach ($discounts as $discount) {
            if (abs($discountAmount - $discount['discountAmount']) < 0.02) {
                $newDiscounts[] = $discount;
                break;
            }
        }

        if (empty($newDiscounts)) {
            $newDiscounts[] = $this->buildOtherDiscount($discountAmount);
        }

        return $newDiscounts;
    }
}
