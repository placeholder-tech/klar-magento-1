<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Adminhtml_Klar_ScheduleController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sales/codeapp_klar/schedule');
        $this->_addContent($this->getLayout()->createBlock('codeapp_klar/adminhtml_schedule_form'));
        $this->renderLayout();

        return $this;
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/codeapp_klar/schedule');
    }

    public function indexAction()
    {
        $this->_title('Schedule Export');
        $this->_initAction();
    }

    public function scheduleAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                /** @var CodeApp_Klar_Model_Service_Klar $klarService */
                $klarService = Mage::getSingleton('codeapp_klar/service_klar');
                $klarService->scheduleExportByDates(
                    $this->getRequest()->getPost('from'),
                    $this->getRequest()->getPost('to')
                );

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codeapp_klar')->__('Orders where scheduled for export'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}