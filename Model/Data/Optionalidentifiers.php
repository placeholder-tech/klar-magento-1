<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Data_Optionalidentifiers extends Varien_Object
{
    /**
     * String constants for property names
     */
    const GOOGLE_ANALYTICS_TRANSACTION_ID = 'google_analytics_transaction_id';
    const ORDER_SOURCE_NAME = 'order_source_name';
    const ORDER_CHANNEL_NAME = 'order_channel_name';
    const ORDER_PLATFORM_NAME = 'order_platform_name';
    const UTM_SOURCE = 'utm_source';
    const UTM_MEDIUM = 'utm_medium';
    const UTM_CAMPAIGN = 'utm_campaign';
    const UTM_TERM = 'utm_term';
    const UTM_CONTENT = 'utm_content';
    const LANDING_PAGE = 'landing_page';
    const IS_SUBSCRIPTION_ORDER = 'is_subscription_order';
    const IS_FIRST_SUBSCRIPTION_ORDER = 'is_first_subscription_order';

    /**
     * Getter for GoogleAnalyticsTransactionId.
     *
     * @return string|null
     */
    public function getGoogleAnalyticsTransactionId()
    {
        return $this->getData(self::GOOGLE_ANALYTICS_TRANSACTION_ID);
    }

    /**
     * Setter for GoogleAnalyticsTransactionId.
     *
     * @param string|null $googleAnalyticsTransactionId
     *
     * @return void
     */
    public function setGoogleAnalyticsTransactionId(string $googleAnalyticsTransactionId)
    {
        $this->setData(self::GOOGLE_ANALYTICS_TRANSACTION_ID, $googleAnalyticsTransactionId);
    }

    /**
     * Getter for OrderSourceName.
     *
     * @return string|null
     */
    public function getOrderSourceName()
    {
        return $this->getData(self::ORDER_SOURCE_NAME);
    }

    /**
     * Setter for OrderSourceName.
     *
     * @param string|null $orderSourceName
     *
     * @return void
     */
    public function setOrderSourceName(string $orderSourceName)
    {
        $this->setData(self::ORDER_SOURCE_NAME, $orderSourceName);
    }

    /**
     * Getter for OrderChannelName.
     *
     * @return string|null
     */
    public function getOrderChannelName()
    {
        return $this->getData(self::ORDER_CHANNEL_NAME);
    }

    /**
     * Setter for OrderChannelName.
     *
     * @param string|null $orderChannelName
     *
     * @return void
     */
    public function setOrderChannelName(string $orderChannelName)
    {
        $this->setData(self::ORDER_CHANNEL_NAME, $orderChannelName);
    }

    /**
     * Getter for OrderPlatformName.
     *
     * @return string|null
     */
    public function getOrderPlatformName()
    {
        return $this->getData(self::ORDER_PLATFORM_NAME);
    }

    /**
     * Setter for OrderPlatformName.
     *
     * @param string|null $orderPlatformName
     *
     * @return void
     */
    public function setOrderPlatformName(string $orderPlatformName)
    {
        $this->setData(self::ORDER_PLATFORM_NAME, $orderPlatformName);
    }

    /**
     * Getter for UtmSource.
     *
     * @return string|null
     */
    public function getUtmSource()
    {
        return $this->getData(self::UTM_SOURCE);
    }

    /**
     * Setter for UtmSource.
     *
     * @param string|null $utmSource
     *
     * @return void
     */
    public function setUtmSource(string $utmSource)
    {
        $this->setData(self::UTM_SOURCE, $utmSource);
    }

    /**
     * Getter for UtmMedium.
     *
     * @return string|null
     */
    public function getUtmMedium()
    {
        return $this->getData(self::UTM_MEDIUM);
    }

    /**
     * Setter for UtmMedium.
     *
     * @param string|null $utmMedium
     *
     * @return void
     */
    public function setUtmMedium(string $utmMedium)
    {
        $this->setData(self::UTM_MEDIUM, $utmMedium);
    }

    /**
     * Getter for UtmCampaign.
     *
     * @return string|null
     */
    public function getUtmCampaign()
    {
        return $this->getData(self::UTM_CAMPAIGN);
    }

    /**
     * Setter for UtmCampaign.
     *
     * @param string|null $utmCampaign
     *
     * @return void
     */
    public function setUtmCampaign(string $utmCampaign)
    {
        $this->setData(self::UTM_CAMPAIGN, $utmCampaign);
    }

    /**
     * Getter for UtmTerm.
     *
     * @return string|null
     */
    public function getUtmTerm()
    {
        return $this->getData(self::UTM_TERM);
    }

    /**
     * Setter for UtmTerm.
     *
     * @param string|null $utmTerm
     *
     * @return void
     */
    public function setUtmTerm(string $utmTerm)
    {
        $this->setData(self::UTM_TERM, $utmTerm);
    }

    /**
     * Getter for UtmContent.
     *
     * @return string|null
     */
    public function getUtmContent()
    {
        return $this->getData(self::UTM_CONTENT);
    }

    /**
     * Setter for UtmContent.
     *
     * @param string|null $utmContent
     *
     * @return void
     */
    public function setUtmContent(string $utmContent)
    {
        $this->setData(self::UTM_CONTENT, $utmContent);
    }

    /**
     * Getter for LandingPage.
     *
     * @return string|null
     */
    public function getLandingPage()
    {
        return $this->getData(self::LANDING_PAGE);
    }

    /**
     * Setter for LandingPage.
     *
     * @param string|null $landingPage
     *
     * @return void
     */
    public function setLandingPage(string $landingPage)
    {
        $this->setData(self::LANDING_PAGE, $landingPage);
    }

    /**
     * Getter for IsSubscriptionOrder.
     *
     * @return bool|null
     */
    public function getIsSubscriptionOrder()
    {
        return $this->getData(self::IS_SUBSCRIPTION_ORDER) === null ? null
            : (bool)$this->getData(self::IS_SUBSCRIPTION_ORDER);
    }

    /**
     * Setter for IsSubscriptionOrder.
     *
     * @param bool|null $isSubscriptionOrder
     *
     * @return void
     */
    public function setIsSubscriptionOrder(bool $isSubscriptionOrder)
    {
        $this->setData(self::IS_SUBSCRIPTION_ORDER, $isSubscriptionOrder);
    }

    /**
     * Getter for IsFirstSubscriptionOrder.
     *
     * @return bool|null
     */
    public function getIsFirstSubscriptionOrder()
    {
        return $this->getData(self::IS_FIRST_SUBSCRIPTION_ORDER) === null ? null
            : (bool)$this->getData(self::IS_FIRST_SUBSCRIPTION_ORDER);
    }

    /**
     * Setter for IsFirstSubscriptionOrder.
     *
     * @param bool|null $isFirstSubscriptionOrder
     *
     * @return void
     */
    public function setIsFirstSubscriptionOrder(bool $isFirstSubscriptionOrder)
    {
        $this->setData(self::IS_FIRST_SUBSCRIPTION_ORDER, $isFirstSubscriptionOrder);
    }
}
