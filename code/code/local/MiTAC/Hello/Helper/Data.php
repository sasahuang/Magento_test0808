<?php
class MiTAC_Hello_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getMessageUrl()
	{
		return Mage::getUrl('mhello/message/index');
	}
}
