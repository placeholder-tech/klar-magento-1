<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Data_Discount extends Varien_Object
{
    /**
     * String constants for property names
     */
    const TITLE = 'title';
    const DESCRIPTOR = 'descriptor';
    const IS_VOUCHER = 'is_voucher';
    const VOUCHER_CODE = 'voucher_code';
    const VOUCHER_TYPE = 'voucher_type';
    const DISCOUNT_AMOUNT = 'discount_amount';

    /*
     * Other constants
     */
    const DEFAULT_DISCOUNT_TITLE = 'Total Discount';
    const SPECIAL_PRICE_DISCOUNT_TITLE = 'Price Reduction';
    const SPECIAL_PRICE_DISCOUNT_DESCRIPTOR = 'Price Reduction';
    const OTHER_DISCOUNT_TITLE = 'Other Discount';
    const OTHER_DISCOUNT_DESCRIPTOR = 'Other Discount';


    /**
     * Getter for Title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Setter for Title.
     *
     * @param string|null $title
     *
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->setData(self::TITLE, $title);
    }

    /**
     * Getter for Descriptor.
     *
     * @return string|null
     */
    public function getDescriptor()
    {
        return $this->getData(self::DESCRIPTOR);
    }

    /**
     * Setter for Descriptor.
     *
     * @param string|null $descriptor
     *
     * @return void
     */
    public function setDescriptor(string $descriptor)
    {
        $this->setData(self::DESCRIPTOR, $descriptor);
    }

    /**
     * Getter for IsVoucher.
     *
     * @return bool|null
     */
    public function getIsVoucher()
    {
        return $this->getData(self::IS_VOUCHER) === null ? null
            : (bool)$this->getData(self::IS_VOUCHER);
    }

    /**
     * Setter for IsVoucher.
     *
     * @param bool|null $isVoucher
     *
     * @return void
     */
    public function setIsVoucher(bool $isVoucher)
    {
        $this->setData(self::IS_VOUCHER, $isVoucher);
    }

    /**
     * Getter for VoucherCode.
     *
     * @return string|null
     */
    public function getVoucherCode()
    {
        return $this->getData(self::VOUCHER_CODE);
    }

    /**
     * Setter for VoucherCode.
     *
     * @param string|null $voucherCode
     *
     * @return void
     */
    public function setVoucherCode(string $voucherCode)
    {
        $this->setData(self::VOUCHER_CODE, $voucherCode);
    }

    /**
     * Getter for VoucherType.
     *
     * @return string|null
     */
    public function getVoucherType()
    {
        return $this->getData(self::VOUCHER_TYPE);
    }

    /**
     * Setter for VoucherType.
     *
     * @param string|null $voucherType
     *
     * @return void
     */
    public function setVoucherType(string $voucherType)
    {
        $this->setData(self::VOUCHER_TYPE, $voucherType);
    }

    /**
     * Getter for DiscountAmount.
     *
     * @return float|null
     */
    public function getDiscountAmount()
    {
        return $this->getData(self::DISCOUNT_AMOUNT) === null ? null
            : (float)$this->getData(self::DISCOUNT_AMOUNT);
    }

    /**
     * Setter for DiscountAmount.
     *
     * @param float|null $discountAmount
     *
     * @return void
     */
    public function setDiscountAmount(float $discountAmount)
    {
        $this->setData(self::DISCOUNT_AMOUNT, $discountAmount);
    }
}
