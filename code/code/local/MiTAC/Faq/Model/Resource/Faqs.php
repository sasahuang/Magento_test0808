<?php
class MiTAC_Faq_Model_Resource_Faqs extends Mage_Core_Model_Resource_Db_Abstract
{
	public function _construct()
	{
		$this->_init('mitacfaq/faqs', 'entity_id');
	}
}