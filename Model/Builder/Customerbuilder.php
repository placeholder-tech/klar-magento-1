<?php

class Klar_DataSync_Model_Builder_Customerbuilder extends Klar_DataSync_Model_Abstractapirequestparamsbuilder
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

        /* @var Klar_DataSync_Model_Data_Customer $customer */
        $customer = Mage::getModel('klar_datasync/data_customer');

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
        return Mage::helper('klar_datasync')->getMD5Hash($customerEmail);
    }

    /**
     * @return Klar_DataSync_Helper_Config
     */
    private function getConfig()
    {
        return Mage::helper('klar_datasync/config');
    }
}
