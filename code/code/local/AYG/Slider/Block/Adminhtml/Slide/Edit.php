<?php
class AYG_Slider_Block_Adminhtml_Slide_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_objectId = 'id';
        $this->_blockGroup = 'slider';
        $this->_controller = 'adminhtml_slide';
        
        $this->_updateButton('save', 'label', Mage::helper('adminhtml')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('adminhtml')->__('Delete Item'));
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    
    public function getHeaderText()
    {
        if (Mage::registry('slide_data') && Mage::registry('slide_data')->getId()) {
            return Mage::helper('slider')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('slide_data')->getTitle()));
        } else {
            return Mage::helper('slider')->__('Add Item');
        }
    }
}
