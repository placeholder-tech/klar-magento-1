<?php

class ICT_Klar_Model_Api
{
    const BATCH_SIZE = 5;

    private $requestData;

    private $helper;

    private $curlClient;

    /**
     * @param int[] $ids
     */
    public function validateAndSend(array $ids)
    {
        $result = 0;
        $salesOrders = $this->getOrders($ids);

        if ($salesOrders) {
            $this->setRequestData($salesOrders);
        } else {
            return $result;
        }

        if ($this->validate($salesOrders)) {
            $result = $this->json($salesOrders);
        } elseif (count($ids) > 1) {
            foreach ($ids as $id) {
                $result += $this->validateAndSend([$id]);
            }
        }

    }

    /**
     * @param int[] $orderIds
     */
    private function getOrders(array $orderIds)
    {
        if ($this->getConfig()->isEnabled()) {
            $orders = Mage::getModel('sales/order')->getCollection()
                        ->addFieldToFilter('entity_id', ['in', $orderIds]);

            if (count($orders) !== count($orderIds)) {
                Mage::throwException(
                    Mage::helper('ict_klar')->__(
                        'Could not find orders with ids: `%ids`',
                        [
                            'ids' => implode(', ', array_diff(array_keys($orders), $orderIds))
                        ]
                    )
                );
            }
            return $orders;
        }

        return null;
    }

    /**
     * Make order validate request.
     *
     * @param Mage_Sales_Model_Order[] $salesOrders
     *
     * @return bool
     */
    private function validate(array $salesOrders)
    {
        $orderIds = implode(', ', array_keys($salesOrders));
        $this->getHelper()->log($this->getHelper()->__('Validating orders "#%1".', $orderIds));

        if (count($salesOrders) > self::BATCH_SIZE) {
            $this->getHelper()->log(
                $this->getHelper()->__('Batch size must be less or equal %1, %2 provided.', self::BATCH_SIZE, count($salesOrders))
            );
            return false;
        }

        $this->getCurlClient()->post(
            $this->getRequestUrl(self::ORDERS_VALIDATE_PATH, true),
            $this->requestData
        );

        if ($this->getCurlClient()->getStatus() === self::STATUS_OK) {
            return $this->handleSuccess($orderIds);
        }

        if ($this->getCurlClient()->getStatus() === self::STATUS_BAD_REQUEST) {
            return $this->handleError($orderIds);
        }

        $this->logger->info(__('Failed to validate orders "#%1".', $orderIds));

        return false;
    }

    /**
     * Set request data.
     *
     * @param Mage_Sales_Model_Order[] $salesOrders
     *
     * @return void
     */
    private function setRequestData(array $salesOrders)
    {
        try {
            $items = [];
            foreach ($salesOrders as $salesOrder) {
                $items[] = $this->getParamsBuilder()->buildFromSalesOrder($salesOrder);
            }

            $this->requestData = json_encode($items);
        } catch (Exception $e) {
            $this->getHelper()->log($this->getHelper()->__('Error building params: %1', $e->getMessage()));
        }
    }

    /**
     * @return ICT_Klar_Model_Api_Requestparamsbuilder
     */
    private function getParamsBuilder()
    {
        return Mage::getModel('ict_klar/api_requesparamsbuilder');
    }

    /**
     * @return ICT_Klar_Helper_Config
     */
    private function getConfig()
    {
        return Mage::helper('ict_klar/config');
    }

    /**
     * @return ICT_Klar_Helper_Data
     */
    private function getHelper()
    {
        if (!$this->helper) {
            $this->helper = Mage::helper('ict_klar');
        }
        
        return $this->helper;
    }

    /**
     * Get CURL client.
     *
     * @return ICT_Klar_Model_Api_Client
     */
    private function getCurlClient()
    {
        if (!$this->curlClient) {
            $this->curlClient = Mage::getModel('ict_klar/api_client');
            $this->curlClient->setHeaders($this->getHeaders());
        }

        return $this->curlClient;
    }

    /**
     * Get request headers.
     *
     * @return string[]
     */
    private function getHeaders()
    {
        return [
            'Expect' => '',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ];
    }
}