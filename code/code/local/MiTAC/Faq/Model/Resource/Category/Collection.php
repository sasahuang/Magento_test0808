<?php
class MiTAC_Faq_Model_Resource_Category_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('mitacfaq/category');
	}
}