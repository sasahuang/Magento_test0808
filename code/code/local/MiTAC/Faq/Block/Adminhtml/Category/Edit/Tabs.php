<?php
class MiTAC_Faq_Block_Adminhtml_Category_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('faqcategory_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle('Faq Category Information');
	}
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
		'label' => 'Faq Category Information',
		'title' => 'Faq Category Information',
		'content' =>
		$this->getLayout()->createBlock('mitacfaq/adminhtml_category_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}