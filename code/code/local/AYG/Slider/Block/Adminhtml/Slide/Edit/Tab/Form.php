<?php
class AYG_Slider_Block_Adminhtml_Slide_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $model = Mage::registry('slide_data');
        
        $fieldset = $form->addFieldset('slide_form', array('legend' => Mage::helper('slider')->__('Item information')));
        
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('slider')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
        
        $fieldset->addField('img_src', 'image', array(
            'label'     => Mage::helper('slider')->__('Image File'),
            'required'  => false,
            'name'      => 'img_src',
			'after_element_html' => '<p class="note"><span>recommended dimensions: 1280 x 400</span></p>',
        ));
        
        $fieldset->addField('img_alt', 'text', array(
            'label'     => Mage::helper('slider')->__('Image Alt'),
            'required'  => false,
            'name'      => 'img_alt',
        ));
        
        $fieldset->addField('sort_order', 'text', array(
            'label'     => Mage::helper('slider')->__('Sort Order'),
            'required'  => false,
            'name'      => 'sort_order',
        ));
        
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('slider')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('slider')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('slider')->__('Disabled'),
                ),
            ),
        ));
        
        $fieldset->addField('url', 'text', array(
            'label'     => Mage::helper('slider')->__('Web Url'),
            'required'  => false,
            'name'      => 'url',
        ));
        
        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('store_id', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('slider')->__('Store View'),
                'title'     => Mage::helper('slider')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
            //$renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            //$field->setRenderer($renderer);
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }
        
        Mage::dispatchEvent('slider_slide_prepare_form', array('form' => $form));
        
        if ( Mage::getSingleton('adminhtml/session')->getSlideData() ) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideData());
            Mage::getSingleton('adminhtml/session')->setSlideData(null);
        } elseif ( Mage::registry('slide_data') ) {
            $form->setValues(Mage::registry('slide_data')->getData());
        }
        
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
}
