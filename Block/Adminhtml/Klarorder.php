<?php

class Klar_DataSync_Block_Adminhtml_Klarorder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_klarorder';
        $this->_blockGroup = 'klar_datasync';
        $this->_headerText = Mage::helper('klar_datasync')->__('Klar Orders');
        parent::__construct();
        $this->removeButton('add');
    }
}