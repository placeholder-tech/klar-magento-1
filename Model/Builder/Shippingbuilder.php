<?php

class Klar_DataSync_Model_Builder_Shippingbuilder extends Klar_DataSync_Model_Abstractapirequestparamsbuilder
{
    /**
     * Build shipping from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(Mage_Sales_Model_Order $salesOrder)
    {
        $shippingAddress = $salesOrder->getShippingAddress();
        /* @var Klar_DataSync_Model_Data_Shipping $shipping */
        $shipping = Mage::getModel('klar_datasync/data_shipping');

        if ($shippingAddress) {
          $shipping->setCity($shippingAddress->getCity());
          $shipping->setProvinceOrState($shippingAddress->getRegion());
          $shipping->setCountryCodeIso3Letter($this->getCountryCodeIso3Letter($shippingAddress->getCountryId()));
          $shipping->setCountryCodeIso2Letter($shippingAddress->getCountryId());
          $shipping->setZipOrPostalCode($shippingAddress->getPostcode());
        }

        $shippingAmount = $salesOrder->getShippingInclTax();
        $shippingTaxAmount = $salesOrder->getShippingTaxAmount();
        $shippingDiscountAmount = $salesOrder->getShippingDiscountAmount();
        $shippingAmountAfterTaxAndDiscount = $shippingAmount - $shippingTaxAmount - $shippingDiscountAmount;
        $shipping->setCurrencyCodeIso3Letter($salesOrder->getOrderCurrencyCode());
        $shipping->setProviderDescriptor($salesOrder->getShippingDescription());
        $shipping->setShippingTotalAmountBeforeTaxAndDiscounts((float)$shippingAmount);
        $shipping->setDiscounts($this->getDiscounts($salesOrder));
        $shipping->setTaxes($this->getTaxes($salesOrder));
        $shipping->setShippingTotalAmountAfterTaxAndDiscounts($shippingAmountAfterTaxAndDiscount);

        return $this->snakeToCamel($shipping->toArray());
    }

    /**
     * Get country ISO 3 code.
     *
     * @param string $countryId
     *
     * @return string
     */
    private function getCountryCodeIso3Letter($countryId)
    {
        $country = Mage::getModel('directory/country')->loadByCode($countryId);
        return $country->getData('iso3_code');
    }

    /**
     * Get shipping discounts from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    private function getDiscounts(Mage_Sales_Model_Order $salesOrder)
    {
        $discountAmount = (float)$salesOrder->getShippingDiscountAmount();

        if ($discountAmount) {
            /* @var Klar_DataSync_Model_Data_Discount $discount */
            $discount = Mage::getModel('klar_datasync/data_discount');

            $discount->setTitle(Klar_DataSync_Model_Data_Discount::DEFAULT_DISCOUNT_TITLE);
            $discount->setDiscountAmount($discountAmount);

            return [$this->snakeToCamel($discount->toArray())];
        }

        return [];
    }

    /**
     * Get shipping taxes.
     *
     * @param int $orderId
     *
     * @return array
     */
    private function getTaxes(Mage_Sales_Model_Order $order)
    {
        /** @var Klar_DataSync_Model_Builder_Taxesbuilder $taxesBuilder */
        $taxesBuilder = Mage::getSingleton('klar_datasync/builder_taxesbuilder');

        return $taxesBuilder->buildForShipping($order);
    }
}
