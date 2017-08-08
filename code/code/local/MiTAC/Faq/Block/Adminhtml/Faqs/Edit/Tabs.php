<?php
class MiTAC_Faq_Block_Adminhtml_Faqs_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('faqs_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle('Faq Information');
	}
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
		'label' => 'Faq Information',
		'title' => 'Faq Information',
		'content' =>
		$this->getLayout()->createBlock('mitacfaq/adminhtml_faqs_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}