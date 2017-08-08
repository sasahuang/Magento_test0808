<?php
class AYG_Slider_Model_Slide extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'slider_slide';
    protected $_eventObject = 'slide';
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('slider/slide');
    }
}
