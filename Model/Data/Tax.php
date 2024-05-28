<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Data_Tax extends Varien_Object
{   
    /**
     * String constants for property names
     */
    const TITLE = 'title';
    const DESCRIPTOR = 'descriptor';
    const TAX_RATE = 'tax_rate';
    const TAX_AMOUNT = 'tax_amount';

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
    public function setTitle($title)
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
    public function setDescriptor($descriptor)
    {
        $this->setData(self::DESCRIPTOR, $descriptor);
    }

    /**
     * Getter for TaxRate.
     *
     * @return float|null
     */
    public function getTaxRate()
    {
        return $this->getData(self::TAX_RATE) === null ? null
            : (float)$this->getData(self::TAX_RATE);
    }

    /**
     * Setter for TaxRate.
     *
     * @param float|null $taxRate
     *
     * @return void
     */
    public function setTaxRate($taxRate)
    {
        $this->setData(self::TAX_RATE, $taxRate);
    }

    /**
     * Getter for TaxAmount.
     *
     * @return float|null
     */
    public function getTaxAmount()
    {
        return $this->getData(self::TAX_AMOUNT) === null ? null
            : (float)$this->getData(self::TAX_AMOUNT);
    }

    /**
     * Setter for TaxAmount.
     *
     * @param float|null $taxAmount
     *
     * @return void
     */
    public function setTaxAmount($taxAmount)
    {
        $this->setData(self::TAX_AMOUNT, $taxAmount);
    }
}
