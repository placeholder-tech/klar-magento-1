<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_LineitemsBuilder extends CodeApp_Klar_Model_Abstractapirequestparamsbuilder
{
    /**
     * Build line items array from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(Mage_Sales_Model_Order $salesOrder)
    {
        $lineItems = [];

        foreach ($salesOrder->getItemsCollection() as $salesOrderItem) {
            if ($salesOrderItem->getParentItemId()) {
                continue;
            }
            $product = $salesOrderItem->getProduct();
            $productVariant = $this->getProductVariant($salesOrderItem);
            $productBrand = false;
            $categoryName = $this->getCategoryName($salesOrderItem);
            $totalBeforeTaxesAndDiscounts = $salesOrderItem->getOriginalPrice() * $salesOrderItem->getQtyOrdered();
            $weightInGrams = 0;

            if ($product) {
                $productBrand = $product->getAttributeText('manufacturer');
                $weightInGrams = $this->getWeightInGrams($product);
            }

            /* @var CodeApp_Klar_Model_Data_Lineitem $lineItem */
            $lineItem = Mage::getModel('codeapp_klar/data_lineitem');

            $lineItem->setId((string)$salesOrderItem->getItemId());
            $lineItem->setProductName($salesOrderItem->getName());
            $lineItem->setProductId((string)$salesOrderItem->getProductId());

            if ($productVariant) {
                $lineItem->setProductVariantName($productVariant['name']);
                $lineItem->setProductVariantId((string)$productVariant['id']);
            }

            if ($productBrand) {
                $lineItem->setProductBrand($productBrand);
            }

            if ($categoryName) {
                $lineItem->setProductCollection($categoryName);
            }

            $lineItem->setProductCogs((float)$salesOrderItem->getBaseCost());
            $lineItem->setProductGmv((float)$salesOrderItem->getOriginalPrice());
            $lineItem->setProductShippingWeightInGrams($weightInGrams);
            $lineItem->setSku($salesOrderItem->getSku());
            $lineItem->setQuantity((float)$salesOrderItem->getQtyOrdered());
            $lineItem->setDiscounts(
                Mage::getSingleton('codeapp_klar/builder_lineitemdiscountbuilder')->buildFromSalesOrderItem($salesOrderItem)
            );

            $lineItem->setTaxes(
                Mage::getSingleton('codeapp_klar/builder_taxesbuilder')->buildForOrderItem($salesOrderItem)
            );

            $lineItem->setTotalAmountBeforeTaxesAndDiscounts($totalBeforeTaxesAndDiscounts);

            $totalAfterTaxesAndDiscounts = $this->calculateTotalAfterTaxesAndDiscounts($lineItem);
            $lineItem->setTotalAmountAfterTaxesAndDiscounts($totalAfterTaxesAndDiscounts ?: 0.0);

            $lineItems[] = $this->snakeToCamel($lineItem->toArray());
        }

        return $lineItems;
    }

    /**
     * Get product variant name and ID.
     *
     * @param Mage_Sales_Model_Order_Item $salesOrderItem
     *
     * @return array|false
     */
    private function getProductVariant(Mage_Sales_Model_Order_Item $salesOrderItem)
    {
        $productOptions = $salesOrderItem->getProductOptions();

        if (isset($productOptions['simple_name'], $productOptions['simple_sku'])) {
            return [
                'name' => $productOptions['simple_name'],
                'id' => $productOptions['simple_sku'],
            ];
        }

        return false;
    }

    /**
     * Get the highest level category name.
     *
     * @param Mage_Sales_Model_Order_Item $salesOrderItem
     *
     * @return string|null
     */
    private function getCategoryName(Mage_Sales_Model_Order_Item $salesOrderItem)
    {
        $product = $salesOrderItem->getProduct();

        if (!$product) {
            return null;
        }

        $categoryIds = $product->getCategoryIds();
        $categoryNames = [];

        foreach ($categoryIds as $categoryId) {
            try {
                $category = Mage::getModel('catalog/category')->load($categoryId);
            } catch (Mage_Core_Exception $e) {
                continue;
            }

            $categoryLevel = $category->getLevel();
            $categoryName = $category->getName();
            $categoryNames[$categoryLevel] = $categoryName;
        }

        if (!empty($categoryNames)) {
            krsort($categoryNames);

            return reset($categoryNames);
        }

        return null;
    }

    /**
     * Get product weight in grams.
     *
     * @param Mage_Catalog_Model_Product $product
     *
     * @return float
     */
    private function getWeightInGrams(Mage_Catalog_Model_Product $product)
    {
        $productWeightInKgs = 0.00;
        $productWeight = (float)$product->getWeight();

        if ($productWeight) {
            return $productWeightInKgs * 1000;
        }

        return $productWeightInKgs;
    }

    /**
     * Calculate line item total after taxes and discounts.
     *
     * @param CodeApp_Klar_Model_Data_Lineitem $lineItem
     *
     * @return float
     */
    private function calculateTotalAfterTaxesAndDiscounts(CodeApp_Klar_Model_Data_Lineitem $lineItem)
    {
        $taxAmount = 0;
        $discountAmount = 0;
        $quantity = $lineItem->getQuantity();
        $productGmv = $lineItem->getProductGmv() * $quantity;

        foreach ($lineItem->getTaxes() as $lineItemTax) {
            $taxAmount += round($lineItemTax['taxAmount'] * $quantity, 2);
        }

        foreach ($lineItem->getDiscounts() as $lineItemDiscount) {
            $discountAmount += $lineItemDiscount['discountAmount'] * $quantity;
        }

        return $productGmv - $taxAmount - $discountAmount;
    }
}