<?php

class Klar_DataSync_Model_Data_Order extends Varien_Object
{
    /**
     * String constants for property names
     */
    const ID = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const PROCESSED_AT = 'processed_at';
    const CLOSED_AT = 'closed_at';
    const CANCELLED_AT = 'cancelled_at';
    const CURRENCY_CODE_ISO3_LETTER = 'currency_code_iso3_letter';
    const FINANCIAL_STATUS = 'financial_status';
    const SHIPMENT_STATUS = 'shipment_status';
    const PAYMENT_GATEWAY_NAME = 'payment_gateway_name';
    const PAYMENT_METHOD_NAME = 'payment_method_name';
    const ORDER_NAME = 'order_name';
    const ORDER_NUMBER = 'order_number';
    const TAGS = 'tags';
    const LINE_ITEMS = 'line_items';
    const REFUNDED_LINE_ITEMS = 'refunded_line_items';
    const SHIPPING = 'shipping';
    const TRANSACTION_COSTS = 'transaction_costs';
    const CUSTOMER = 'customer';
    const OPTIONAL_IDENTIFIERS = 'optional_identifiers';

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
     * @param string|null $value
     *
     * @return void
     */
    public function setId($value)
    {
        $this->setData(self::ID, $value);
    }

    /**
     * Getter for CreatedAt.
     *
     * @return int|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT) === null ? null
            : (int)$this->getData(self::CREATED_AT);
    }

    /**
     * Setter for CreatedAt.
     *
     * @param int|null $createdAt
     *
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Getter for UpdatedAt.
     *
     * @return int|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT) === null ? null
            : (int)$this->getData(self::UPDATED_AT);
    }

    /**
     * Setter for UpdatedAt.
     *
     * @param int|null $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Getter for ProcessedAt.
     *
     * @return int|null
     */
    public function getProcessedAt()
    {
        return $this->getData(self::PROCESSED_AT) === null ? null
            : (int)$this->getData(self::PROCESSED_AT);
    }

    /**
     * Setter for ProcessedAt.
     *
     * @param int|null $processedAt
     *
     * @return void
     */
    public function setProcessedAt($processedAt)
    {
        $this->setData(self::PROCESSED_AT, $processedAt);
    }

    /**
     * Getter for ClosedAt.
     *
     * @return int|null
     */
    public function getClosedAt()
    {
        return $this->getData(self::CLOSED_AT) === null ? null
            : (int)$this->getData(self::CLOSED_AT);
    }

    /**
     * Setter for ClosedAt.
     *
     * @param int|null $closedAt
     *
     * @return void
     */
    public function setClosedAt($closedAt)
    {
        $this->setData(self::CLOSED_AT, $closedAt);
    }

    /**
     * Getter for CancelledAt.
     *
     * @return int|null
     */
    public function getCancelledAt()
    {
        return $this->getData(self::CANCELLED_AT) === null ? null
            : (int)$this->getData(self::CANCELLED_AT);
    }

    /**
     * Setter for CancelledAt.
     *
     * @param int|null $cancelledAt
     *
     * @return void
     */
    public function setCancelledAt($cancelledAt)
    {
        $this->setData(self::CANCELLED_AT, $cancelledAt);
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
     * Getter for FinancialStatus.
     *
     * @return string|null
     */
    public function getFinancialStatus()
    {
        return $this->getData(self::FINANCIAL_STATUS);
    }

    /**
     * Setter for FinancialStatus.
     *
     * @param string|null $financialStatus
     *
     * @return void
     */
    public function setFinancialStatus($financialStatus)
    {
        $this->setData(self::FINANCIAL_STATUS, $financialStatus);
    }

    /**
     * Getter for ShipmentStatus.
     *
     * @return string|null
     */
    public function getShipmentStatus()
    {
        return $this->getData(self::SHIPMENT_STATUS);
    }

    /**
     * Setter for ShipmentStatus.
     *
     * @param string|null $shipmentStatus
     *
     * @return void
     */
    public function setShipmentStatus($shipmentStatus)
    {
        $this->setData(self::SHIPMENT_STATUS, $shipmentStatus);
    }

    /**
     * Getter for PaymentGatewayName.
     *
     * @return string|null
     */
    public function getPaymentGatewayName()
    {
        return $this->getData(self::PAYMENT_GATEWAY_NAME);
    }

    /**
     * Setter for PaymentGatewayName.
     *
     * @param string|null $paymentGatewayName
     *
     * @return void
     */
    public function setPaymentGatewayName($paymentGatewayName)
    {
        $this->setData(self::PAYMENT_GATEWAY_NAME, $paymentGatewayName);
    }

    /**
     * Getter for PaymentMethodName.
     *
     * @return string|null
     */
    public function getPaymentMethodName()
    {
        return $this->getData(self::PAYMENT_METHOD_NAME);
    }

    /**
     * Setter for PaymentMethodName.
     *
     * @param string|null $paymentMethodName
     *
     * @return void
     */
    public function setPaymentMethodName($paymentMethodName)
    {
        $this->setData(self::PAYMENT_METHOD_NAME, $paymentMethodName);
    }

    /**
     * Getter for OrderName.
     *
     * @return string|null
     */
    public function getOrderName()
    {
        return $this->getData(self::ORDER_NAME);
    }

    /**
     * Setter for OrderName.
     *
     * @param string|null $orderName
     *
     * @return void
     */
    public function setOrderName($orderName)
    {
        $this->setData(self::ORDER_NAME, $orderName);
    }

    /**
     * Getter for OrderNumber.
     *
     * @return string|null
     */
    public function getOrderNumber()
    {
        return $this->getData(self::ORDER_NUMBER);
    }

    /**
     * Setter for OrderNumber.
     *
     * @param string|null $orderNumber
     *
     * @return void
     */
    public function setOrderNumber($orderNumber)
    {
        $this->setData(self::ORDER_NUMBER, $orderNumber);
    }

    /**
     * Getter for Tags.
     *
     * @return string|null
     */
    public function getTags()
    {
        return $this->getData(self::TAGS);
    }

    /**
     * Setter for Tags.
     *
     * @param string|null $tags
     *
     * @return void
     */
    public function setTags($tags)
    {
        $this->setData(self::TAGS, $tags);
    }

    /**
     * Getter for LineItems.
     *
     * @return array|null
     */
    public function getLineItems()
    {
        return $this->getData(self::LINE_ITEMS);
    }

    /**
     * Setter for LineItems.
     *
     * @param array|null $lineItems
     *
     * @return void
     */
    public function setLineItems(array $lineItems)
    {
        $this->setData(self::LINE_ITEMS, $lineItems);
    }

    /**
     * Getter for RefundedLineItems.
     *
     * @return array|null
     */
    public function getRefundedLineItems()
    {
        return $this->getData(self::REFUNDED_LINE_ITEMS);
    }

    /**
     * Setter for RefundedLineItems.
     *
     * @param array|null $refundedLineItems
     */
    public function setRefundedLineItems(array $refundedLineItems)
    {
        $this->setData(self::REFUNDED_LINE_ITEMS, $refundedLineItems);
    }

    /**
     * Getter for Shipping.
     *
     * @return array|null
     */
    public function getShipping()
    {
        return $this->getData(self::SHIPPING);
    }

    /**
     * Setter for Shipping.
     *
     * @param array $shipping
     *
     * @return void
     */
    public function setShipping(array $shipping)
    {
        $this->setData(self::SHIPPING, $shipping);
    }

    /**
     * Getter for TransactionCosts.
     *
     * @return float|null
     */
    public function getTransactionCosts()
    {
        return $this->getData(self::TRANSACTION_COSTS);
    }

    /**
     * Setter for Transaction Costs.
     *
     * @param float|null $transactionCosts
     *
     * @return void
     */
    public function setTransactionCosts($transactionCosts)
    {
        $this->setData(self::TRANSACTION_COSTS, $transactionCosts);
    }

    /**
     * Getter for Customer.
     *
     * @return array|null
     */
    public function getCustomer()
    {
        return $this->getData(self::CUSTOMER);
    }

    /**
     * Setter for Customer.
     *
     * @param array $customer
     *
     * @return void
     */
    public function setCustomer(array $customer)
    {
        $this->setData(self::CUSTOMER, $customer);
    }

    /**
     * Getter for OptionalIdentifiers.
     *
     * @return array|null
     */
    public function getOptionalIdentifiers()
    {
        return $this->getData(self::OPTIONAL_IDENTIFIERS);
    }

    /**
     * Setter for OptionalIdentifiers.
     *
     * @param array $optionalIdentifiers
     *
     * @return void
     */
    public function setOptionalIdentifiers(array $optionalIdentifiers)
    {
        $this->setData(self::OPTIONAL_IDENTIFIERS, $optionalIdentifiers);
    }
}
