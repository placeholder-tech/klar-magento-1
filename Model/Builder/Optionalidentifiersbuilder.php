<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Optionalidentifiersbuilder extends CodeApp_Klar_Model_Abstracatpirequestparamsbuilder
{
    private OptionalIdentifiersInterfaceFactory $optionalIdentifiersFactory;

    /**
     * OptionalIdentifiersBuilder builder.
     *
     * @param DateTimeFactory $dateTimeFactory
     * @param OptionalIdentifiersInterfaceFactory $optionalIdentifiersFactorybin
     */
    public function __construct(
        DateTimeFactory $dateTimeFactory,
        OptionalIdentifiersInterfaceFactory $optionalIdentifiersFactory,
    ) {
        parent::__construct($dateTimeFactory);
        $this->optionalIdentifiersFactory = $optionalIdentifiersFactory;
    }

    /**
     * Build OptionalIdentifiers from sales order.
     *
     * @param SalesOrderInterface $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(SalesOrderInterface $salesOrder): array
    {
        $optionalIdentifiers = $this->optionalIdentifiersFactory->create();
        $optionalIdentifiers->setGoogleAnalyticsTransactionId($salesOrder->getIncrementId());

        return $this->snakeToCamel($optionalIdentifiers->toArray());
    }
}
