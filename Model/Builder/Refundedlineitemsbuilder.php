<?php

class ICT_Klar_Model_Builder_Refundedlineitemsbuilder extends ICT_Klar_Model_Abstracatpirequestparamsbuilder
{
    private RefundedLineItemInterfaceFactory $refundedLineItemFactory;

    /**
     * RefundedLineItemsBuilder constructor.
     *
     * @param DateTimeFactory $dateTimeFactory
     * @param RefundedLineItemInterfaceFactory $refundedLineItemFactory
     */
    public function __construct(
        DateTimeFactory $dateTimeFactory,
        RefundedLineItemInterfaceFactory $refundedLineItemFactory
    ) {
        parent::__construct($dateTimeFactory);
        $this->refundedLineItemFactory = $refundedLineItemFactory;
    }

    /**
     * Build refunded line items array from sales order.
     *
     * @param SalesOrderInterface $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(SalesOrderInterface $salesOrder): array
    {
        $refundedLineItems = [];

        foreach ($salesOrder->getItems() as $salesOrderItem) {
            if (!(float)$salesOrderItem->getQtyRefunded()) {
                continue;
            }

            /* @var RefundedLineItemInterface $refundedLineItem */
            $refundedLineItem = $this->refundedLineItemFactory->create();

            $refundedLineItem->setId((string)$salesOrderItem->getId());
            $refundedLineItem->setLineItemId((string)$salesOrderItem->getId());
            $refundedLineItem->setRefundedQuantity((float)$salesOrderItem->getQtyRefunded());
            $refundedLineItem->setCreatedAt($this->getTimestamp($salesOrderItem->getUpdatedAt()));

            $refundedLineItems[] = $this->snakeToCamel($refundedLineItem->toArray());
        }

        return $refundedLineItems;
    }
}
