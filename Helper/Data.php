<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * @param string $message
     * @param integer $level
     */
    public function log($message, $level = Zend_Log::INFO)
    {
        Mage::log($message, $level, 'klar.log', true);
    }

    /**
     * 
     * @param string $string
     * 
     * @return string
     */
    public function getMD5Hash($string)
    {
        return md5($string);
    }
}
