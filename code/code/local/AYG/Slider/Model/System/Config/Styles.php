<?php
class AYG_Slider_Model_System_Config_Styles 
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('fade')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('linear')),
            array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('random')),
        );
    }
}
