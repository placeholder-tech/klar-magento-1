<?php

class Klar_DataSync_Model_Builder_Optionalidentifiersbuilder extends Klar_DataSync_Model_Abstractapirequestparamsbuilder
{
    /**
     * Build OptionalIdentifiers from sales order.
     *
     * @param Mage_Sales_Model_Order $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(Mage_Sales_Model_Order $salesOrder)
    {
        /** @var Klar_DataSync_Model_Data_Optionalidentifiers $optionalIdentifiers */
        $optionalIdentifiers = Mage::getModel('klar_datasync/data_optionalidentifiers');
        $optionalIdentifiers->setGoogleAnalyticsTransactionId($salesOrder->getIncrementId());

        return $this->snakeToCamel($optionalIdentifiers->toArray());
    }
}
