<?php

class ICT_Klar_Helper_Config extends Mage_Core_Helper_Data
{
    const XML_PATH_ORDER_STATES = 'global/sales/order/states';
    const CONFIG_PATH_ENABLED = 'klar/integration/enabled';

    private $enabled;
    
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
}
