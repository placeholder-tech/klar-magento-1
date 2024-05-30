<?php

class Klar_DataSync_Model_Resource_KlarOrder extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('klar_datasync/klarorder', 'entity_id');
    }
}