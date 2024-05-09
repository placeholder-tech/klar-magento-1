<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

 /** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
        ->newTable($installer->getTable('codeapp_klar/klarorder'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'primary'   => true,
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false
        ), 'Entity Id')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Order ID')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'unsigned'  => true,
            'default'   => '0',
        ), 'Status')
        ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
            'nullable'  => true,
        ), 'Message')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ), 'Creation Time')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE
        ), 'Update Time')
        ->addForeignKey($installer->getFkName('codeapp_klar/klarorder', 'order_id', 'sales/order', 'entity_id'),
            'order_id', $installer->getTable('sales/order'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Klar Orders Table');

$installer->getConnection()->createTable($table);

$installer->endSetup(); 