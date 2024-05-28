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
        $collection = Mage::getModel('codeapp_klar/klarorder')
                        ->getCollection()
                        ->addFieldToFilter('status', CodeApp_Klar_Model_Klarorder::STATUS_PENDING)
                        ->setPageSize(self::BATCH_SIZE)
                        ->setCurPage(1);

        /** @var CodeApp_Klar_Model_Klarorder $item */
        foreach ($collection as $item) {

            try {
                $item->setStatus(CodeApp_Klar_Model_Klarorder::STATUS_PROCESSING);
                $item->save();
                
                $this->getApi()->validateAndSend([$item->getOrderId()]);
                
                $item->setStatus(CodeApp_Klar_Model_Klarorder::STATUS_SUCCESS);
                $item->save();
            } catch (Exception $e) {
                $item->setMessage($e->getMessage());
                $item->setStatus(CodeApp_Klar_Model_Klarorder::STATUS_ERROR);
                $item->save();
            }
        }
    }
    
    /**
     * @return CodeApp_Klar_Model_Api
     */
    private function getApi()
    {
        if (!$this->api) {
            $this->api = Mage::getModel('codeapp_klar/api');
        }

        return $this->api;
    }
}