<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

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
        $this->_title('Orders Status');
        $this->_initAction();
    }
}