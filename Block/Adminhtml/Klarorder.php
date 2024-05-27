<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Block_Adminhtml_Klarorder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_klarorder';
        $this->_blockGroup = 'codeapp_klar';
        $this->_headerText = Mage::helper('codeapp_klar')->__('Klar Orders');
        parent::__construct();
        $this->removeButton('add');
    }
}