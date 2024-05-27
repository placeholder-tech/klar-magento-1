<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Optionalidentifiersbuilder extends CodeApp_Klar_Model_Abstractapirequestparamsbuilder
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
        /** @var CodeApp_Klar_Model_Data_Optionalidentifiers $optionalIdentifiers */
        $optionalIdentifiers = Mage::getModel('codeapp_klar/data_optionalidentifiers');
        $optionalIdentifiers->setGoogleAnalyticsTransactionId($salesOrder->getIncrementId());

        return $this->snakeToCamel($optionalIdentifiers->toArray());
    }
}
