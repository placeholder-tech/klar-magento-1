<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Data_Lineitem extends Varien_Object
{
    /**
     * String constants for property names
     */
    const ID = 'id';
    const PRODUCT_NAME = 'product_name';
    const PRODUCT_ID = 'product_id';
    const PRODUCT_VARIANT_NAME = 'product_variant_name';
    const PRODUCT_VARIANT_ID = 'product_variant_id';
    const PRODUCT_BRAND = 'product_brand';
    const PRODUCT_COLLECTION = 'product_collection';
    const PRODUCT_COGS = 'product_cogs';
    const PRODUCT_GMV = 'product_gmv';
    const PRODUCT_SHIPPING_WEIGHT_IN_GRAMS = 'product_shipping_weight_in_grams';
    const SKU = 'sku';
    const QUANTITY = 'quantity';
    const PRODUCT_TAGS = 'product_tags';
    const TOTAL_AMOUNT_BEFORE_TAXES_AND_DISCOUNTS = 'total_amount_before_taxes_and_discounts';
    const TOTAL_AMOUNT_AFTER_TAXES_AND_DISCOUNTS = 'total_amount_after_taxes_and_discounts';
    const TOTAL_LOGISTICS_COSTS = 'total_logistics_costs';
    const DISCOUNTS = 'discounts';
    const TAXES = 'taxes';

    /**
     * Getter for Id.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Setter for Id.
     *
     * @param string|null $id
     *
     * @return void
     */
    public function setId($value)
    {
        $this->setData(self::ID, $value);
    }

    /**
     * Getter for ProductName.
     *
     * @return string|null
     */
    public function getProductName()
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    /**
     * Setter for ProductName.
     *
     * @param string|null $productName
     *
     * @return void
     */
    public function setProductName($productName)
    {
        $this->setData(self::PRODUCT_NAME, $productName);
    }

    /**
     * Getter for ProductId.
     *
     * @return string|null
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Setter for ProductId.
     *
     * @param string|null $productId
     *
     * @return void
     */
    public function setProductId($productId)
    {
        $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * Getter for ProductVariantName.
     *
     * @return string|null
     */
    public function getProductVariantName()
    {
        return $this->getData(self::PRODUCT_VARIANT_NAME);
    }

    /**
     * Setter for ProductVariantName.
     *
     * @param string|null $productVariantName
     *
     * @return void
     */
    public function setProductVariantName($productVariantName)
    {
        $this->setData(self::PRODUCT_VARIANT_NAME, $productVariantName);
    }

    /**
     * Getter for ProductVariantId.
     *
     * @return string|null
     */
    public function getProductVariantId()
    {
        return $this->getData(self::PRODUCT_VARIANT_ID);
    }

    /**
     * Setter for ProductVariantId.
     *
     * @param string|null $productVariantId
     *
     * @return void
     */
    public function setProductVariantId($productVariantId)
    {
        $this->setData(self::PRODUCT_VARIANT_ID, $productVariantId);
    }

    /**
     * Getter for ProductBrand.
     *
     * @return string|null
     */
    public function getProductBrand()
    {
        return $this->getData(self::PRODUCT_BRAND);
    }

    /**
     * Setter for ProductBrand.
     *
     * @param string|null $productBrand
     *
     * @return void
     */
    public function setProductBrand($productBrand)
    {
        $this->setData(self::PRODUCT_BRAND, $productBrand);
    }

    /**
     * Getter for ProductCollection.
     *
     * @return string|null
     */
    public function getProductCollection()
    {
        return $this->getData(self::PRODUCT_COLLECTION);
    }

    /**
     * Setter for ProductCollection.
     *
     * @param string|null $productCollection
     *
     * @return void
     */
    public function setProductCollection($productCollection)
    {
        $this->setData(self::PRODUCT_COLLECTION, $productCollection);
    }

    /**
     * Getter for ProductCogs.
     *
     * @return float|null
     */
    public function getProductCogs()
    {
        return $this->getData(self::PRODUCT_COGS) === null ? null
            : (float)$this->getData(self::PRODUCT_COGS);
    }

    /**
     * Setter for ProductCogs.
     *
     * @param float|null $productCogs
     *
     * @return void
     */
    public function setProductCogs($productCogs)
    {
        $this->setData(self::PRODUCT_COGS, $productCogs);
    }

    /**
     * Getter for ProductGmv.
     *
     * @return float|null
     */
    public function getProductGmv()
    {
        return $this->getData(self::PRODUCT_GMV) === null ? null
            : (float)$this->getData(self::PRODUCT_GMV);
    }

    /**
     * Setter for ProductGmv.
     *
     * @param float|null $productGmv
     *
     * @return void
     */
    public function setProductGmv($productGmv)
    {
        $this->setData(self::PRODUCT_GMV, $productGmv);
    }

    /**
     * Getter for ProductShippingWeightInGrams.
     *
     * @return float|null
     */
    public function getProductShippingWeightInGrams()
    {
        return $this->getData(self::PRODUCT_SHIPPING_WEIGHT_IN_GRAMS) === null ? null
            : (float)$this->getData(self::PRODUCT_SHIPPING_WEIGHT_IN_GRAMS);
    }

    /**
     * Setter for ProductShippingWeightInGrams.
     *
     * @param float|null $productShippingWeightInGrams
     *
     * @return void
     */
    public function setProductShippingWeightInGrams($productShippingWeightInGrams)
    {
        $this->setData(self::PRODUCT_SHIPPING_WEIGHT_IN_GRAMS, $productShippingWeightInGrams);
    }

    /**
     * Getter for Sku.
     *
     * @return string|null
     */
    public function getSku()
    {
        return $this->getData(self::SKU);
    }

    /**
     * Setter for Sku.
     *
     * @param string|null $sku
     *
     * @return void
     */
    public function setSku($sku)
    {
        $this->setData(self::SKU, $sku);
    }

    /**
     * Getter for Quantity.
     *
     * @return float|null
     */
    public function getQuantity()
    {
        return $this->getData(self::QUANTITY) === null ? null
            : (float)$this->getData(self::QUANTITY);
    }

    /**
     * Setter for Quantity.
     *
     * @param float|null $quantity
     *
     * @return void
     */
    public function setQuantity($quantity)
    {
        $this->setData(self::QUANTITY, $quantity);
    }

    /**
     * Getter for ProductTags.
     *
     * @return string|null
     */
    public function getProductTags()
    {
        return $this->getData(self::PRODUCT_TAGS);
    }

    /**
     * Setter for ProductTags.
     *
     * @param string|null $productTags
     *
     * @return void
     */
    public function setProductTags($productTags)
    {
        $this->setData(self::PRODUCT_TAGS, $productTags);
    }

    /**
     * Getter for TotalAmountBeforeTaxesAndDiscounts.
     *
     * @return float|null
     */
    public function getTotalAmountBeforeTaxesAndDiscounts()
    {
        return $this->getData(self::TOTAL_AMOUNT_BEFORE_TAXES_AND_DISCOUNTS) === null ? null
            : (float)$this->getData(self::TOTAL_AMOUNT_BEFORE_TAXES_AND_DISCOUNTS);
    }

    /**
     * Setter for TotalAmountBeforeTaxesAndDiscounts.
     *
     * @param float|null $totalAmountBeforeTaxesAndDiscounts
     *
     * @return void
     */
    public function setTotalAmountBeforeTaxesAndDiscounts($totalAmountBeforeTaxesAndDiscounts)
    {
        $this->setData(self::TOTAL_AMOUNT_BEFORE_TAXES_AND_DISCOUNTS, $totalAmountBeforeTaxesAndDiscounts);
    }

    /**
     * Getter for TotalAmountAfterTaxesAndDiscounts.
     *
     * @return float|null
     */
    public function getTotalAmountAfterTaxesAndDiscounts()
    {
        return $this->getData(self::TOTAL_AMOUNT_AFTER_TAXES_AND_DISCOUNTS) === null ? null
            : (float)$this->getData(self::TOTAL_AMOUNT_AFTER_TAXES_AND_DISCOUNTS);
    }

    /**
     * Setter for TotalAmountAfterTaxesAndDiscounts.
     *
     * @param float|null $totalAmountAfterTaxesAndDiscounts
     *
     * @return void
     */
    public function setTotalAmountAfterTaxesAndDiscounts($totalAmountAfterTaxesAndDiscounts)
    {
        $this->setData(self::TOTAL_AMOUNT_AFTER_TAXES_AND_DISCOUNTS, $totalAmountAfterTaxesAndDiscounts);
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
