<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Model_Builder_Customerbuilder extends CodeApp_Klar_Model_Abstracatpirequestparamsbuilder
{
    private CustomerInterfaceFactory $customerFactory;
    private EncryptorInterface $encryptor;

    private Config $config;
    /**
     * CustomerBuilder builder.
     *
     * @param DateTimeFactory $dateTimeFactory
     * @param CustomerInterfaceFactory $customerFactory
     * @param EncryptorInterface $encryptor
     * @param Config $config
     *
     */
    public function __construct(
        DateTimeFactory $dateTimeFactory,
        CustomerInterfaceFactory $customerFactory,
        EncryptorInterface $encryptor,
        Config $config,
    ) {
        parent::__construct($dateTimeFactory);
        $this->customerFactory = $customerFactory;
        $this->encryptor = $encryptor;
        $this->config = $config;
    }

    /**
     * Build customer from sales order.
     *
     * @param SalesOrderInterface $salesOrder
     *
     * @return array
     */
    public function buildFromSalesOrder(SalesOrderInterface $salesOrder): array
    {
        $customerId = $salesOrder->getCustomerId();
        $customerEmail = $this->config->getSendEmail() ? $salesOrder->getCustomerEmail() : "redacted@getklar.com";
        $customerEmailHash = sha1($this->config->getPublicKey() . $salesOrder->getCustomerEmail());

        if (!$customerId) {
            $customerId = $this->generateGuestCustomerId($customerEmail);
        }

        /* @var CustomerInterface $customer */
        $customer = $this->customerFactory->create();

        $customer->setId((string)$customerId);
        $customer->setEmail($customerEmail);
        $customer->setEmailHash($customerEmailHash);

        return $this->snakeToCamel($customer->toArray());
    }

    /**
     * Generate guest customer ID as per Klar recommendation.
     *
     * @param string $customerEmail
     *
     * @return string
     */
    private function generateGuestCustomerId(string $customerEmail): string
    {
        return $this->encryptor->hash($customerEmail, Encryptor::HASH_VERSION_MD5);
    }
}
