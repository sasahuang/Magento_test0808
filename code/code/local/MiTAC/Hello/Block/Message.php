<?php
class Mitac_Hello_Block_Message extends Mage_Core_Block_Template
{
   public function getPostActionUrl()
	{
		return Mage::getUrl('mhello/message/post');
	}

	public function getMessages()
	{		
		$messages = Mage::getModel('mitachello/message')->getCollection()
														->addFieldToFilter(
														"status", array("eq" => 1));
		return $messages;	
	}
}
