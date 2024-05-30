<?php

class Klar_DataSync_Adminhtml_Klar_ScheduleController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sales/klar_datasync/schedule');
        $this->_addContent($this->getLayout()->createBlock('klar_datasync/adminhtml_schedule_form'));
        $this->renderLayout();

        return $this;
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/klar_datasync/schedule');
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
                /** @var Klar_DataSync_Model_Service_Klar $klarService */
                $klarService = Mage::getSingleton('klar_datasync/service_klar');
                $klarService->scheduleExportByDates(
                    $this->getRequest()->getPost('from'),
                    $this->getRequest()->getPost('to')
                );

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('klar_datasync')->__('Orders where scheduled for export'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}