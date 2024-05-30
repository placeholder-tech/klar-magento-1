<?php

class Klar_DataSync_Model_Cron_Order
{
    const BATCH_SIZE = 5;

    private $api;

    public function synchronizeOrders()
    {   
        $collection = Mage::getModel('klar_datasync/klarorder')
                        ->getCollection()
                        ->addFieldToFilter('status', Klar_DataSync_Model_Klarorder::STATUS_PENDING)
                        ->setPageSize(self::BATCH_SIZE)
                        ->setCurPage(1);

        /** @var Klar_DataSync_Model_Klarorder $item */
        foreach ($collection as $item) {

            try {
                $item->setStatus(Klar_DataSync_Model_Klarorder::STATUS_PROCESSING);
                $item->save();
                
                $this->getApi()->validateAndSend([$item->getOrderId()]);
                
                $item->setStatus(Klar_DataSync_Model_Klarorder::STATUS_SUCCESS);
                $item->save();
            } catch (Exception $e) {
                $item->setMessage($e->getMessage());
                $item->setStatus(Klar_DataSync_Model_Klarorder::STATUS_ERROR);
                $item->save();
            }
        }
    }
    
    /**
     * @return Klar_DataSync_Model_Api
     */
    private function getApi()
    {
        if (!$this->api) {
            $this->api = Mage::getModel('klar_datasync/api');
        }

        return $this->api;
    }
}