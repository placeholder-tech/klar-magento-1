<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Block_Adminhtml_Klarorder_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('klarorderGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('codeapp_klar/klarorder')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('codeapp_klar')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));

        $this->addColumn('order_id', array(
            'header'    => Mage::helper('codeapp_klar')->__('Order ID'),
            'align'     =>'left',
            'index'     => 'order_id',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('codeapp_klar')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                0 => 'Pending',
                1 => 'Processing',
                2 => 'Complete',
                3 => 'Failed'
            ),
        ));

        $this->addColumn('message', array(
            'header'    => Mage::helper('codeapp_klar')->__('Message'),
            'align'     => 'left',
            'index'     => 'message',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('codeapp_klar')->__('Created At'),
            'index'  => 'created_at',
            'type'   => 'datetime',
            'width'  => '150px',
            'filter' => false,
            'sortable'  => false,
        ));
    
        $this->addColumn('updated_at', array(
            'header' => Mage::helper('codeapp_klar')->__('Updated At'),
            'index'  => 'updated_at',
            'type'   => 'datetime',
            'width'  => '150px',
            'filter' => false,
            'sortable'  => false,
        ));

        return parent::_prepareColumns();
    }
}