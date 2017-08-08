<?php
class Mitac_Faq_Block_Faqs extends Mage_Core_Block_Template
{
    public function getFaqs()
	{
		$faqCategories = Mage::getModel('mitacfaq/category')->getCollection()
		->addFieldToFilter('status', array('eq' => 1));
		$faqData = array();
		
		foreach($faqCategories as $category)
		{
			$data = array();
			$id = $category->getId();
			$faqs = Mage::getModel('mitacfaq/faqs')->getCollection()
			->addFieldToFilter('category_id', array('eq' => $id))
			->addFieldToFilter('status', array('eq' => 1));
			
			foreach($faqs as $faq)
			{
				$data[$faq->getId()]['title'] = $faq->getTitle();
				$data[$faq->getId()]['content']= $faq->getContent();
			}
			$faqData[$id]['name'] = $category->getName();
			$faqData[$id]['data'] = $data;
		}
		return $faqData;
	}
}