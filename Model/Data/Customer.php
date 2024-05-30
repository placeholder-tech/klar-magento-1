<?php

class Klar_DataSync_Model_Data_Customer extends Varien_Object
{
    /**
     * String constants for property names
     */
    const ID = 'id';
    const EMAIL = 'email';
    const IS_NEWSLETTER_SUBSCRIBER_AT_TIME_OF_CHECKOUT = 'is_newsletter_subscriber_at_time_of_checkout';
    const TAGS = 'tags';
    const EMAIL_HASH = 'emailHash';

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
     * Getter for Email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Setter for Email Hash.
     *
     * @param string|null $email
     *
     * @return void
     */
    public function setEmailHash($emailHash)
    {
        $this->setData(self::EMAIL_HASH, $emailHash);
    }

    /**
     * Getter for Email Hash.
     *
     * @return string|null
     */
    public function getEmailHash()
    {
        return $this->getData(self::EMAIL_HASH);
    }

    /**
     * Setter for Email.
     *
     * @param string|null $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
    }


    /**
     * Getter for IsNewsletterSubscriberAtTimeOfCheckout.
     *
     * @return bool|null
     */
    public function getIsNewsletterSubscriberAtTimeOfCheckout()
    {
        return $this->getData(self::IS_NEWSLETTER_SUBSCRIBER_AT_TIME_OF_CHECKOUT) === null ? null
            : (bool)$this->getData(self::IS_NEWSLETTER_SUBSCRIBER_AT_TIME_OF_CHECKOUT);
    }

    /**
     * Setter for IsNewsletterSubscriberAtTimeOfCheckout.
     *
     * @param bool|null $isNewsletterSubscriberAtTimeOfCheckout
     *
     * @return void
     */
    public function setIsNewsletterSubscriberAtTimeOfCheckout(bool $isNewsletterSubscriberAtTimeOfCheckout)
    {
        $this->setData(self::IS_NEWSLETTER_SUBSCRIBER_AT_TIME_OF_CHECKOUT, $isNewsletterSubscriberAtTimeOfCheckout);
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
}
