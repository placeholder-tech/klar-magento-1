<?php

class CodeApp_Klar_Adminhtml_Klar_OrderController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sales/codeapp_klar/order');
        $this->_addContent($this->getLayout()->createBlock('codeapp_klar/adminhtml_klarorder'));
        $this->renderLayout();

        return $this;
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/codeapp_klar/order');
    }

    public function indexAction()
    {
        $this->_title('Klar Orders');
        $this->_initAction();

        // Example of adding a success notice message
        //Mage::getSingleton('adminhtml/session')->addSuccess('{Success Message Text}');

        // Example of adding an error notice message
        //Mage::getSingleton('adminhtml/session')->addError('{Error Message Text}');
    }
}