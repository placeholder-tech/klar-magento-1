<?php

class Klar_DataSync_Model_Service_Klar
{
    public function scheduleExportByDates($from = null, $to = null)
    {
        $orders = Mage::getModel('sales/order')
                    ->getCollection();
        if ($from) {
            $orders->addFieldToFilter('created_at', array('gt' => $from));
        }

        if ($to) {
            $orders->addFieldToFilter('created_at', array('lt' => $to));
        }

        foreach ($orders as $order) {
            $this->createKlarOrderFromSalesOrder($order);
        }
    }

    private function createKlarOrderFromSalesOrder(Mage_Sales_Model_Order $order)
    {
        try {
            $klarOrder = Mage::getModel('klar_datasync/klarorder');
            $klarOrder->setData('order_id', $order->getId());
            $klarOrder->setData('status', Klar_DataSync_Model_Klarorder::STATUS_PENDING);
            $klarOrder->save();
        } catch (Exception $e) {
            $message = Mage::helper('klar_datasync')->__('Error saving klar order for export: %s', $e->getMessage());
            Mage::helper('klar_datasync')->log($message, Zend_Log::ERR);
            Mage::throwException($message);
        }
    }
}