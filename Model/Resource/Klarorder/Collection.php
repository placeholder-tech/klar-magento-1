<?php

class Klar_DataSync_Model_Resource_KlarOrder_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('klar_datasync/klarorder');
    }
}