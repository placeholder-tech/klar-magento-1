<?php

class Klar_DataSync_Adminhtml_Klar_OrderController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sales/klar_datasync/order');
        $this->_addContent($this->getLayout()->createBlock('klar_datasync/adminhtml_klarorder'));
        $this->renderLayout();

        return $this;
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/klar_datasync/order');
    }

    public function indexAction()
    {
        $this->_title('Orders Status');
        $this->_initAction();
    }
}