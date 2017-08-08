<?php
class Mitac_Faq_Block_Adminhtml_Faqs extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_faqs';
        $this->_blockGroup = 'mitacfaq';
        $this->_headerText = 'FAQ 管理';
        
        parent::__construct();
    }
}