<?php

class ICT_Klar_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * @param string $message
     * @param integer $level
     */
    public function log($message, $level = Zend_Log::INFO)
    {
        Mage::log($message, $level, 'klar.log', true);
    }
}
