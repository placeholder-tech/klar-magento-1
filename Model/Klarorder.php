<?php

class Klar_DataSync_Model_Klarorder extends Mage_Core_Model_Abstract
{
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ERROR = 3;

    protected function _construct()
    {
        $this->_init('klar_datasync/klarorder');
    }
}