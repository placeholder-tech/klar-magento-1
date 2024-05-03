<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Lineitemdiscountbuilder extends CodeApp_Klar_Model_Abstracatpirequestparamsbuilder
{
    private DiscountInterfaceFactory $discountFactory;
    private RuleRepositoryInterface $salesRuleRepository;
    private RuleFactory $ruleFactory;

    /**
     * LineItemDiscountsBuilder constructor.
     *
     * @param DateTimeFactory $dateTimeFactory
     * @param DiscountInterfaceFactory $discountFactory
     * @param RuleRepositoryInterface $salesRuleRepository
     * @param RuleFactory $ruleFactory
     */
    public function __construct(
        DateTimeFactory $dateTimeFactory,
        DiscountInterfaceFactory $discountFactory,
        RuleRepositoryInterface $salesRuleRepository,
        RuleFactory $ruleFactory
    ) {
        parent::__construct($dateTimeFactory);
        $this->discountFactory = $discountFactory;
        $this->salesRuleRepository = $salesRuleRepository;
        $this->ruleFactory = $ruleFactory;
    }

    /**
     * Build line item discounts array from sales order item.
     *
     * @param SalesOrderItemInterface $salesOrderItem
     *
     * @return array
     */
    public function buildFromSalesOrderItem(SalesOrderItemInterface $salesOrderItem): array
    {
        $discounts = [];
        $discountAmount = (float)$salesOrderItem->getDiscountAmount();
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
    private function buildRuleDiscount(int $ruleId, float $baseItemPrice): array
    {
        try {
            $salesRule = $this->salesRuleRepository->getById($ruleId);
        } catch (NoSuchEntityException|LocalizedException $e) {
            // Rule doesn't exist, manual calculation is not possible.
            return [];
        }

        if (!(float)$salesRule->getDiscountAmount()) {
            return [];
        }

        /* @var DiscountInterface $discount */
        $discount = $this->discountFactory->create();

        $discount->setTitle($salesRule->getName());
        $discount->setDescriptor($salesRule->getDescription());

        if ($salesRule->getCouponType() === RuleInterface::COUPON_TYPE_SPECIFIC_COUPON) {
            $couponCode = $this->ruleFactory->create()->load($ruleId)->getCouponCode();

            $discount->setIsVoucher(true);
            $discount->setVoucherCode($couponCode);
        }

        if ($salesRule->getSimpleAction() === RuleInterface::DISCOUNT_ACTION_BY_PERCENT) {
            $discountPercent = $salesRule->getDiscountAmount() / 100;
            $discount->setDiscountAmount($baseItemPrice * $discountPercent);
        } elseif ($salesRule->getSimpleAction() === RuleInterface::DISCOUNT_ACTION_FIXED_AMOUNT) {
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
    private function buildOtherDiscount(float $discountLeft): array
    {
        /* @var DiscountInterface $discount */
        $discount = $this->discountFactory->create();

        $discount->setTitle(DiscountInterface::OTHER_DISCOUNT_TITLE);
        $discount->setDescriptor(DiscountInterface::OTHER_DISCOUNT_DESCRIPTOR);
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
    private function buildSpecialPriceDiscount(float $price, float $originalPrice): array
    {
        /* @var DiscountInterface $discount */
        $discount = $this->discountFactory->create();

        $discount->setTitle(DiscountInterface::SPECIAL_PRICE_DISCOUNT_TITLE);
        $discount->setDescriptor(DiscountInterface::SPECIAL_PRICE_DISCOUNT_DESCRIPTOR);
        $discount->setDiscountAmount($originalPrice - $price);

        return $this->snakeToCamel($discount->toArray());
    }

    private function sumCalculatedDiscounts(array $discounts): float
    {
        $calculatedDiscounts = 0.00;
        foreach ($discounts as $discount) {
            $calculatedDiscounts += isset($discount['discountAmount']) ? $discount['discountAmount'] : 0.00;
        }

        return round($calculatedDiscounts, 2);
    }

    private function rebuildDiscountsBasedOnFlatData(array $discounts, float $discountAmount): array
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
