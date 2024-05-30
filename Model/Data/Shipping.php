<?php

class Klar_DataSync_Model_Data_Shipping extends Varien_Object
{
    /**
     * String constants for property names
     */
    const CITY = 'city';
    const PROVINCE_OR_STATE = 'province_or_state';
    const COUNTRY_CODE_ISO3_LETTER = 'country_code_iso3_letter';
    const COUNTRY_CODE_ISO2_LETTER = 'country_code_iso2_letter';
    const CURRENCY_CODE_ISO3_LETTER = 'currency_code_iso3_letter';
    const ZIP_OR_POSTAL_CODE = 'zip_or_postal_code';
    const PROVIDER_DESCRIPTOR = 'provider_descriptor';
    const SHIPPING_TOTAL_AMOUNT_BEFORE_TAX_AND_DISCOUNTS = 'shipping_total_amount_before_tax_and_discounts';
    const SHIPPING_TOTAL_AMOUNT_AFTER_TAX_AND_DISCOUNTS = 'shipping_total_amount_after_tax_and_discounts';
    const TOTAL_LOGISTICS_COSTS = 'total_logistics_costs';
    const DISCOUNTS = 'discounts';
    const TAXES = 'taxes';

    /**
     * Getter for City.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * Setter for City.
     *
     * @param string|null $city
     *
     * @return void
     */
    public function setCity($city)
    {
        $this->setData(self::CITY, $city);
    }

    /**
     * Getter for ProvinceOrState.
     *
     * @return string|null
     */
    public function getProvinceOrState()
    {
        return $this->getData(self::PROVINCE_OR_STATE);
    }

    /**
     * Setter for ProvinceOrState.
     *
     * @param string|null $provinceOrState
     *
     * @return void
     */
    public function setProvinceOrState($provinceOrState)
    {
        $this->setData(self::PROVINCE_OR_STATE, $provinceOrState);
    }

    /**
     * Getter for CountryCodeIso3Letter.
     *
     * @return string|null
     */
    public function getCountryCodeIso3Letter()
    {
        return $this->getData(self::COUNTRY_CODE_ISO3_LETTER);
    }

    /**
     * Setter for CountryCodeIso3Letter.
     *
     * @param string|null $countryCodeIso3Letter
     *
     * @return void
     */
    public function setCountryCodeIso3Letter($countryCodeIso3Letter)
    {
        $this->setData(self::COUNTRY_CODE_ISO3_LETTER, $countryCodeIso3Letter);
    }

    /**
     * Getter for CountryCodeIso2Letter.
     *
     * @return string|null
     */
    public function getCountryCodeIso2Letter()
    {
        return $this->getData(self::COUNTRY_CODE_ISO2_LETTER);
    }

    /**
     * Setter for CountryCodeIso2Letter.
     *
     * @param string|null $countryCodeIso2Letter
     *
     * @return void
     */
    public function setCountryCodeIso2Letter($countryCodeIso2Letter)
    {
        $this->setData(self::COUNTRY_CODE_ISO2_LETTER, $countryCodeIso2Letter);
    }

    /**
     * Getter for CurrencyCodeIso3Letter.
     *
     * @return string|null
     */
    public function getCurrencyCodeIso3Letter()
    {
        return $this->getData(self::CURRENCY_CODE_ISO3_LETTER);
    }

    /**
     * Setter for CurrencyCodeIso3Letter.
     *
     * @param string|null $currencyCodeIso3Letter
     *
     * @return void
     */
    public function setCurrencyCodeIso3Letter($currencyCodeIso3Letter)
    {
        $this->setData(self::CURRENCY_CODE_ISO3_LETTER, $currencyCodeIso3Letter);
    }

    /**
     * Getter for ZipOrPostalCode.
     *
     * @return string|null
     */
    public function getZipOrPostalCode()
    {
        return $this->getData(self::ZIP_OR_POSTAL_CODE);
    }

    /**
     * Setter for ZipOrPostalCode.
     *
     * @param string|null $zipOrPostalCode
     *
     * @return void
     */
    public function setZipOrPostalCode($zipOrPostalCode)
    {
        $this->setData(self::ZIP_OR_POSTAL_CODE, $zipOrPostalCode);
    }

    /**
     * Getter for ProviderDescriptor.
     *
     * @return string|null
     */
    public function getProviderDescriptor()
    {
        return $this->getData(self::PROVIDER_DESCRIPTOR);
    }

    /**
     * Setter for ProviderDescriptor.
     *
     * @param string|null $providerDescriptor
     *
     * @return void
     */
    public function setProviderDescriptor($providerDescriptor)
    {
        $this->setData(self::PROVIDER_DESCRIPTOR, $providerDescriptor);
    }

    /**
     * Getter for ShippingTotalAmountBeforeTaxAndDiscounts.
     *
     * @return float|null
     */
    public function getShippingTotalAmountBeforeTaxAndDiscounts()
    {
        return $this->getData(self::SHIPPING_TOTAL_AMOUNT_BEFORE_TAX_AND_DISCOUNTS) === null ? null
            : (float)$this->getData(self::SHIPPING_TOTAL_AMOUNT_BEFORE_TAX_AND_DISCOUNTS);
    }

    /**
     * Setter for ShippingTotalAmountBeforeTaxAndDiscounts.
     *
     * @param float|null $shippingTotalAmountBeforeTaxAndDiscounts
     *
     * @return void
     */
    public function setShippingTotalAmountBeforeTaxAndDiscounts($shippingTotalAmountBeforeTaxAndDiscounts)
    {
        $this->setData(self::SHIPPING_TOTAL_AMOUNT_BEFORE_TAX_AND_DISCOUNTS, $shippingTotalAmountBeforeTaxAndDiscounts);
    }

    /**
     * Getter for ShippingTotalAmountAfterTaxAndDiscounts.
     *
     * @return float|null
     */
    public function getShippingTotalAmountAfterTaxAndDiscounts()
    {
        return $this->getData(self::SHIPPING_TOTAL_AMOUNT_AFTER_TAX_AND_DISCOUNTS) === null ? null
            : (float)$this->getData(self::SHIPPING_TOTAL_AMOUNT_AFTER_TAX_AND_DISCOUNTS);
    }

    /**
     * Setter for ShippingTotalAmountAfterTaxAndDiscounts.
     *
     * @param float|null $shippingTotalAmountAfterTaxAndDiscounts
     *
     * @return void
     */
    public function setShippingTotalAmountAfterTaxAndDiscounts($shippingTotalAmountAfterTaxAndDiscounts)
    {
        $this->setData(self::SHIPPING_TOTAL_AMOUNT_AFTER_TAX_AND_DISCOUNTS, $shippingTotalAmountAfterTaxAndDiscounts);
    }

    /**
     * Getter for TotalLogisticsCosts.
     *
     * @return float|null
     */
    public function getTotalLogisticsCosts()
    {
        return $this->getData(self::TOTAL_LOGISTICS_COSTS) === null ? null
            : (float)$this->getData(self::TOTAL_LOGISTICS_COSTS);
    }

    /**
     * Setter for TotalLogisticsCosts.
     *
     * @param float|null $totalLogisticsCosts
     *
     * @return void
     */
    public function setTotalLogisticsCosts($totalLogisticsCosts)
    {
        $this->setData(self::TOTAL_LOGISTICS_COSTS, $totalLogisticsCosts);
    }

    /**
     * Getter for Discounts.
     *
     * @return array|null
     */
    public function getDiscounts()
    {
        return $this->getData(self::DISCOUNTS);
    }

    /**
     * Setter for Discounts.
     *
     * @param array $discounts
     *
     * @return void
     */
    public function setDiscounts(array $discounts)
    {
        $this->setData(self::DISCOUNTS, $discounts);
    }

    /**
     * Getter for Taxes.
     *
     * @return array|null
     */
    public function getTaxes()
    {
        return $this->getData(self::TAXES);
    }

    /**
     * Setter for Taxes.
     *
     * @param array $taxes
     *
     * @return void
     */
    public function setTaxes(array $taxes)
    {
        $this->setData(self::TAXES, $taxes);
    }
}
