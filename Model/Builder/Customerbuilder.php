<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Customerbuilder extends CodeApp_Klar_Model_Abstracatpirequestparamsbuilder
{
    /**
     * Build customer from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(Mage_Sales_Model_Order $salesOrder)
    {
        $customerId = $salesOrder->getCustomerId();
        $customerEmail = $this->getConfig()->getSendEmail() ? $salesOrder->getCustomerEmail() : $this->getConfig()->getDefaultEmail();
        $customerEmailHash = sha1($this->getConfig()->getPublicKey() . $salesOrder->getCustomerEmail());

        if (!$customerId) {
            $customerId = $this->generateGuestCustomerId($customerEmail);
        }

        /* @var CodeApp_Klar_Model_Data_Customer $customer */
        $customer = Mage::getModel('codeapp_klar/data_customer');

        $customer->setId((string)$customerId);
        $customer->setEmail($customerEmail);
        $customer->setEmailHash($customerEmailHash);

        return $this->snakeToCamel($customer->toArray());
    }

    /**
     * Generate guest customer ID as per Klar recommendation.
     *
     * @param string $customerEmail
     *
     * @return string
     */
    private function generateGuestCustomerId($customerEmail)
    {
        return Mage::helper('codeapp_klar')->getMD5Hash($customerEmail);
    }

    /**
     * @return CodeApp_Klar_Helper_Config
     */
    private function getConfig()
    {
        return Mage::helper('codeapp_klar/config');
    }
}
