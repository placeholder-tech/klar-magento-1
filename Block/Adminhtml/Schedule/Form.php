<?php
/**
 * @author     Sebastian Ruchlewicz <contact@codeapp.pl>
 * @copyright  Copyright (c) 2024 (https://codeapp.pl)
 */

class CodeApp_Klar_Block_Adminhtml_Schedule_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/schedule'),
            'method' => 'post'
        ));
        
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('codeapp_klar')->__('Select Date Range')
        ));

        $fieldset->addField('form_key', 'hidden', array(
            'name'      => 'form_key',
            'value'     => Mage::getSingleton('core/session')->getFormKey(),
        ));
        
        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $fieldset->addField('from', 'date', array(
            'name'   => 'from',
            'label'  => Mage::helper('codeapp_klar')->__('Date From'),
            'title'  => Mage::helper('codeapp_klar')->__('Date From'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => 'yyyy-MM-dd',
            'required'     => true,
        ));

        $fieldset->addField('to', 'date', array(
            'name'   => 'to',
            'label'  => Mage::helper('codeapp_klar')->__('Date To'),
            'title'  => Mage::helper('codeapp_klar')->__('Date To'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => 'yyyy-MM-dd',
            'required'     => true,
        ));

        $fieldset->addField('submit', 'submit', array(
            'name'      => 'submit',
            'value'     => Mage::helper('codeapp_klar')->__('Export'),
            'class'     => 'form-button',
            'title'     => Mage::helper('codeapp_klar')->__('Export'),
            'onclick'   => "this.form.submit();"
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
