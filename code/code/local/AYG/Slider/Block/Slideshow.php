<?php
class AYG_Slider_Block_Slideshow extends Mage_Core_Block_Template
{
    public function getSlides()
    { 
        $slides = Mage::getModel('slider/slide')->getCollection()
            ->addFieldToFilter('status', array('eq' => AYG_Slider_Model_Status::STATUS_ENABLED))
            ->addStoreFilter(Mage::app()->getStore()->getId());
        $slides->getSelect()->order('sort_order');
        return $slides;
    }
}
