<?php
class MiTAC_Faq_Block_Adminhtml_Faqs_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_objectId = 'id';
		$this->_blockGroup = 'mitacfaq';
		$this->_controller = 'adminhtml_faqs';
		$this->_headerText = 'Faq';
		$this->_updateButton('save', 'label', 'Save Faq');
		$this->_updateButton('delete', 'label', 'Delete Faq');
	}
}