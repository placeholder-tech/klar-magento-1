<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Observer_Order
{
    public function createKlarOrder(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        try {
            $klarOrder = Mage::getModel('codeapp_klar/klarorder');
            $klarOrder->setData('order_id', $order->getId());
            $klarOrder->setData('status', CodeApp_Klar_Model_Klarorder::STATUS_PENDING);
            $klarOrder->save();
        } catch (Exception $e) {
            Mage::log('Error saving klar order: ' . $e->getMessage(), null, 'klarorder_errors.log'); // TODO implement log to custom file
        }
    }
}