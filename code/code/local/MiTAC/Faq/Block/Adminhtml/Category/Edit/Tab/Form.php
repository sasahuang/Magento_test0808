<?php
class MiTAC_Faq_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('faqs_form', array('legend' => 'Faq Category information'));
		$fieldset->addField('name', 'text', array(
			'label' => 'Name',
			'class' => 'required-entry',
			'required' => true,
			'name' => 'name',
		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('mitacfaq')->__('Enable'),
			'name' => 'status',
			'values' =>	Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
		));
		
		if (Mage::getSingleton('adminhtml/session')->getFaqcategoryData()) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getFaqcategoryData());
			Mage::getSingleton('adminhtml/session')->getFaqcategoryData(null);
		} elseif (Mage::registry('faqcategory_data')) {
			$form->setValues(Mage::registry('faqcategory_data')->getData());
		}
		return parent::_prepareForm();
	}
}