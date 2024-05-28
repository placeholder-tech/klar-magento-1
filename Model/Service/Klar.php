<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Service_Klar
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
            $klarOrder = Mage::getModel('codeapp_klar/klarorder');
            $klarOrder->setData('order_id', $order->getId());
            $klarOrder->setData('status', CodeApp_Klar_Model_Klarorder::STATUS_PENDING);
            $klarOrder->save();
        } catch (Exception $e) {
            $message = Mage::helper('codeapp_klar')->__('Error saving klar order for export: %s', $e->getMessage());
            Mage::helper('codeapp_klar')->log($message, Zend_Log::ERR);
            Mage::throwException($message);
        }
    }
}