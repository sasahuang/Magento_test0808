<?php
class AYG_Slider_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_SLIDER_GENERAL_SPEED = 'slider/general/speed';
    
    public function getSliderSpeed()
    {
        $speed = Mage::getStoreConfig(self::XML_PATH_SLIDER_GENERAL_SPEED, Mage::app()->getStore());
        if (!is_numeric($speed)) {
            $speed = 5;
        }
        return $speed * 1000;
    }
    
    public function getImagesUploadDir ()
    {
        return Mage::getBaseDir('media').DS.'slider'.DS;
    }
    public function getImageUrl ($image)
    {
        return Mage::getBaseUrl('media').$this->getImageRelativeUrl($image);
    }
    public function getImageRelativeUrl ($image)
    {
        return 'slider/'.$image;
    }
	
	public function getResizeImageUrl($image,$width){
		$info = pathinfo($image);
		
		return Mage::getBaseUrl('media').$this->getImageRelativeUrl($info['filename'].'_'.$width.'.'.$info['extension']);
	}
}
