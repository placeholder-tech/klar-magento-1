<?php

class Klar_DataSync_Block_Adminhtml_Klarorder_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getModel('klar_datasync/klarorder')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('klar_datasync')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));

        $this->addColumn('order_id', array(
            'header'    => Mage::helper('klar_datasync')->__('Order ID'),
            'align'     =>'left',
            'width'     => '80px',
            'index'     => 'order_id',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('klar_datasync')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'width'     => '100px',
            'type'      => 'options',
            'options'   => array(
                0 => 'Pending',
                1 => 'Processing',
                2 => 'Complete',
                3 => 'Failed'
            ),
        ));

        $this->addColumn('message', array(
            'header'    => Mage::helper('klar_datasync')->__('Message'),
            'align'     => 'left',
            'index'     => 'message',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('klar_datasync')->__('Created At'),
            'index'  => 'created_at',
            'type'   => 'datetime',
            'width'  => '150px',
            'filter' => false,
            'sortable'  => false,
        ));
    
        $this->addColumn('updated_at', array(
            'header' => Mage::helper('klar_datasync')->__('Updated At'),
            'index'  => 'updated_at',
            'type'   => 'datetime',
            'width'  => '150px',
            'filter' => false,
            'sortable'  => false,
        ));

        return parent::_prepareColumns();
    }
}