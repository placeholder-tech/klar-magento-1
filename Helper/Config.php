<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Helper_Config extends Mage_Core_Helper_Data
{
    const XML_PATH_ORDER_STATES = 'global/sales/order/states';
    const CONFIG_PATH_ENABLED = 'klar/integration/enabled';
    const CONFIG_PATH_API_URL = 'klar/integration/api_url';
    const CONFIG_PATH_API_VERSION = 'klar/integration/api_version';
    const CONFIG_PATH_API_TOKEN = 'klar/integration/api_token';
    
    const CONFIG_PATH_SEND_EMAIL = 'klar/integration/send_email';
    const CONFIG_PATH_PUBLIC_KEY = 'klar/integration/public_key';

    private $enabled;
    private $apiUrl;
    private $apiVersion;
    private $apiToken;
    
    /**
     * Is the extension enabled?
     *
     * @return bool
     */
    public function isEnabled()
    {
        if (is_null($this->enabled)) {
            $this->enabled = (bool) Mage::getStoreConfig(self::CONFIG_PATH_ENABLED);
        }
        return $this->enabled;
    }

    public function getApiUrl()
    {
        if (is_null($this->apiUrl)) {
            $this->apiUrl = (string) Mage::getStoreConfig(self::CONFIG_PATH_API_URL);
        }
        return $this->apiUrl;
    }

    public function getApiVersion()
    {
        if (is_null($this->apiVersion)) {
            $this->apiVersion = (string) Mage::getStoreConfig(self::CONFIG_PATH_API_VERSION);
        }
        return $this->apiVersion;
    }

    public function getApiToken()
    {
        if (is_null($this->apiToken)) {
            $this->apiToken = (string) Mage::getStoreConfig(self::CONFIG_PATH_API_VERSION);
        }
        return $this->apiToken;
    }
}
