<?php
class MiTAC_Faq_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_category';
		$this->_blockGroup = 'mitacfaq';
		$this->_headerText = 'FAQ 分類管理';
		parent::__construct();
	}
}