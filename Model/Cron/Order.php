<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Cron_Order
{
    const BATCH_SIZE = 5;

    private $api;

    public function synchronizeOrders()
    {   
        Mage::log('start cron');
        // Logic to check the database for active records
        try {
            Mage::log('start cron1');
            $collection = Mage::getModel('codeapp_klar/klarorder')->getCollection()
            ->addFieldToFilter('status', CodeApp_Klar_Model_Klarorder::STATUS_PENDING);
            //->limit(self::BATCH_SIZE);
            Mage::log('start cron2');
        } catch (Exception $e) {
            Mage::log($e->getMessage());
            Mage::log($e->getTraceAsString());
            return;
        }
        
        
            Mage::log('1');

        /** @var CodeApp_Klar_Model_Klarorder $item */
        foreach ($collection as $item) {
            Mage::log('2');
            try {
                Mage::log('3');
                //$item->setStatus(CodeApp_Klar_Model_Klarorder::STATUS_PROCESSING);
                //$item->save();
                Mage::log('4');
                Mage::log($item->getOrderId());
                Mage::log(get_class($this->getApi()));
                $this->getApi()->validateAndSend([$item->getOrderId()]);
                Mage::log('5');
                //$item->setStatus(CodeApp_Klar_Model_Klarorder::STATUS_SUCCESS);
                //$item->save();
                Mage::log('6');
            } catch (Exception $e) {
                Mage::log('7');
                //$item->setMessage($e->getMessage());
                //$item->setStatus(CodeApp_Klar_Model_Klarorder::STATUS_ERROR);
                //$item->save();
                Mage::log($e->getMessage());
                Mage::log($e->getTraceAsString());
                Mage::log('8');
            }
            // Execute synchronization logic
            // Perhaps call an external API
            // Update or log the results as needed
        }

        Mage::log('9');
    }
    
    /**
     * @return CodeApp_Klar_Model_Api
     */
    private function getApi()
    {
        Mage::log('a');
        if (!$this->api) {
            Mage::log('b');
            $this->api = Mage::getModel('codeapp_klar/api');
            Mage::log('c');
        }

        return $this->api;
    }
}