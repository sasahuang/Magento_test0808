<?php
class AYG_Slider_Block_Adminhtml_Slide extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_slide';
        $this->_blockGroup = 'slider';
        $this->_headerText = Mage::helper('slider')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('slider')->__('Add Item');
        
        parent::__construct();
    }
}
