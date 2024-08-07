<?php

class Klar_DataSync_Helper_Data extends Mage_Core_Helper_Data
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

    /**
     * @return array
     */
    public function toArray(Mage_Core_Model_Resource_Db_Collection_Abstract $collection)
    {
        $items = [];

        foreach ($collection as $item) {
            $items[$item->getId()] = $item;
        }
        
        return $items;
    }
}
