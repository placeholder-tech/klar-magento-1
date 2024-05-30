<?php

class Klar_DataSync_Model_Api
{
    const ORDERS_STATUS_PATH = '/orders/status';
    const ORDERS_VALIDATE_PATH = '/orders/validate';
    const ORDERS_JSON_PATH = '/orders/json';
    const ORDER_STATUS_VALID = 'VALID';
    const ORDER_STATUS_INVALID = 'INVALID';
    const STATUS_OK = 201;
    const STATUS_BAD_REQUEST = 400;
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
     * @return Mage_Sales_Model_Order[]
     */
    private function getOrders(array $orderIds)
    {
        if ($this->getConfig()->isEnabled()) {
            $orders = Mage::getModel('sales/order')->getCollection()
                        ->addFieldToFilter('entity_id', ['in', $orderIds]);

            if (count($orders) !== count($orderIds)) {
                Mage::throwException(
                    Mage::helper('klar_datasync')->__(
                        'Could not find orders with ids: `%ids`',
                        [
                            'ids' => implode(', ', array_diff(array_keys($orders), $orderIds))
                        ]
                    )
                );
            }
            return Mage::helper('klar_datasync')->toArray($orders);
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
        $this->getHelper()->log($this->getHelper()->__('Validating orders "#%s".', $orderIds));

        if (count($salesOrders) > self::BATCH_SIZE) {
            $this->getHelper()->log(
                $this->getHelper()->__('Batch size must be less or equal %d, %d provided.', self::BATCH_SIZE, count($salesOrders))
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

        $this->getHelper()->log(
            $this->getHelper()->__('Failed to validate orders "#%s".', $orderIds)
        );

        return false;
    }

    /**
     * Set request data.
     *
     * @param Mage_Sales_Model_Order[] $salesOrders
     * @throws Mage_Core_Exception
     * 
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
            $message = $this->getHelper()->__('Error building params: %s', $e->getMessage());
            $this->getHelper()->log($message, Zend_Log::ERR);
            Mage::throwException($message);
        }
    }

    /**
     * @return Klar_DataSync_Model_Api_Requestparamsbuilder
     */
    private function getParamsBuilder()
    {
        return Mage::getModel('klar_datasync/api_requestparamsbuilder');
    }

    /**
     * @return Klar_DataSync_Helper_Config
     */
    private function getConfig()
    {
        return Mage::helper('klar_datasync/config');
    }

    /**
     * @return Klar_DataSync_Helper_Data
     */
    private function getHelper()
    {
        if (!$this->helper) {
            $this->helper = Mage::helper('klar_datasync');
        }
        
        return $this->helper;
    }

    /**
     * Get CURL client.
     *
     * @return Klar_DataSync_Model_Api_Client
     */
    private function getCurlClient()
    {
        if (!$this->curlClient) {
            $this->curlClient = Mage::getModel('klar_datasync/api_client');
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
            'Authorization' => 'Bearer ' . $this->getConfig()->getApiToken(),
        ];
    }

    /**
     * Get request endpoint URL.
     *
     * @param string $path
     * @param bool $includeVersion
     *
     * @return string
     */
    private function getRequestUrl($path, $includeVersion = false)
    {
        if ($includeVersion) {
            $baseUrl = $this->getConfig()->getApiUrl();
            $version = $this->getConfig()->getApiVersion();

            return rtrim($baseUrl, "/") . '/' . $version . $path;
        }

        return $this->getConfig()->getApiUrl() . $path;
    }

    /**
     * Handle success.
     *
     * @param string $orderIds
     *
     * @return bool
     */
    private function handleSuccess($orderIds)
    {
        $body = $this->getCurlBody();

        if (isset($body['status']) && $body['status'] === self::ORDER_STATUS_VALID) {
            $this->getHelper()->log(
                $this->getHelper()->__('Orders "#%s" is valid and can be sent to Klar.', $orderIds)
            );

            return true;
        }

        return false;
    }

    /**
     * Get curl request response body.
     *
     * @return array
     */
    private function getCurlBody()
    {
        $result = json_decode(
            $this->getCurlClient()->getBody(),
            true,
            512
        );
        
        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            $this->getHelper()->log(
                $this->getHelper()->__('Error getting body from request response: %s', json_last_error_msg())
            );

            return [];
        }
        
        return $result;
    }

    /**
     * Handle error.
     *
     * @param string $orderIds
     *
     * @return bool
     */
    private function handleError($orderIds)
    {
        $body = $this->getCurlBody();

        if (isset($body['status'], $body['errors']) && $body['status'] === self::ORDER_STATUS_INVALID) {
            foreach ($body['errors'] as $errorMessage) {
                $this->getHelper()->log($errorMessage);
            }

            $this->getHelper()->log(
                $this->getHelper()->__('Failed to validate orders "#%s":', $orderIds)
            );

            return false;
        }

        return false;
    }

    /**
     * Make order json request.
     *
     * @param Mage_Sales_Model_Order[] $salesOrders
     *
     * @return int
     */
    private function json(array $salesOrders)
    {
        $result = 0;
        $orderIds = implode(', ', array_keys($salesOrders));
        $this->getHelper()->log(
            $this->getHelper()->__('Sending orders "#%s".', $orderIds)
        );

        $this->getCurlClient()->post(
            $this->getRequestUrl(self::ORDERS_JSON_PATH, true),
            $this->requestData
        );

        if ($this->getCurlClient()->getStatus() === self::STATUS_OK) {
            $this->getHelper()->log(
                $this->getHelper()->__('Orders "#%s" successfully sent to Klar.', $orderIds)
            );
            $result = count($salesOrders);
        } else {
            $this->getHelper()->log(
                $this->getHelper()->__('Failed to send orders "#%s".', $orderIds)
            );
        }

        return $result;
    }
}