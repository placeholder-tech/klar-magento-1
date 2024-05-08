<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Klarorder extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('codeapp_klar/klarorder');
    }
}