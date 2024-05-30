<?php

class Klar_DataSync_Model_Data_Refundedlineitem extends Varien_Object
{
    /**
     * String constants for property names
     */
    const ID = 'id';
    const LINE_ITEM_ID = 'line_item_id';
    const REASON_DESCRIPTOR = 'reason_descriptor';
    const REFUNDED_QUANTITY = 'refunded_quantity';
    const CREATED_AT = 'created_at';
    const PROCESSED_AT = 'processed_at';

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
     * Getter for LineItemId.
     *
     * @return string|null
     */
    public function getLineItemId()
    {
        return $this->getData(self::LINE_ITEM_ID);
    }

    /**
     * Setter for LineItemId.
     *
     * @param string|null $lineItemId
     *
     * @return void
     */
    public function setLineItemId($lineItemId)
    {
        $this->setData(self::LINE_ITEM_ID, $lineItemId);
    }

    /**
     * Getter for ReasonDescriptor.
     *
     * @return string|null
     */
    public function getReasonDescriptor()
    {
        return $this->getData(self::REASON_DESCRIPTOR);
    }

    /**
     * Setter for ReasonDescriptor.
     *
     * @param string|null $reasonDescriptor
     *
     * @return void
     */
    public function setReasonDescriptor($reasonDescriptor)
    {
        $this->setData(self::REASON_DESCRIPTOR, $reasonDescriptor);
    }

    /**
     * Getter for RefundedQuantity.
     *
     * @return float|null
     */
    public function getRefundedQuantity()
    {
        return $this->getData(self::REFUNDED_QUANTITY) === null ? null
            : (float)$this->getData(self::REFUNDED_QUANTITY);
    }

    /**
     * Setter for RefundedQuantity.
     *
     * @param float|null $refundedQuantity
     *
     * @return void
     */
    public function setRefundedQuantity($refundedQuantity)
    {
        $this->setData(self::REFUNDED_QUANTITY, $refundedQuantity);
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
}
