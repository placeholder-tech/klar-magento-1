<?php

class Klar_DataSync_Model_Observer_Order
{
    public function createKlarOrder(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        try {
            $klarOrder = Mage::getModel('klar_datasync/klarorder');
            $klarOrder->setData('order_id', $order->getId());
            $klarOrder->setData('status', Klar_DataSync_Model_Klarorder::STATUS_PENDING);
            $klarOrder->save();
        } catch (Exception $e) {
            Mage::helper('klar_datasync')->log('Error saving klar order for export: ' . $e->getMessage(), Zend_Log::ERR);
        }
    }
}