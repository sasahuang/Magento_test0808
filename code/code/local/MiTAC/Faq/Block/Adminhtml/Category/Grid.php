<?php
class MiTAC_Faq_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
public function __construct()
	{
		parent::__construct();
		$this->setId('categoryGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('mitacfaq/category')->getCollection();
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	protected function _prepareColumns()
	{
		$helper = Mage::helper('mitacfaq');
		$this->addColumn('entity_id', array(
			'header' => $helper->__('Id'),
			'index' => 'entity_id'
		));
		$this->addColumn('name', array(
			'header' => $helper->__('Name'),
			'index' => 'name'
		));
		$this->addColumn('status', array(
			'header' => $helper->__('Status'),
			'index' => 'status',
			'type' => 'options',
			'options' => array(
			1 => 'Enabled',
			0 => 'Disabled',
			)//,
		));
		return parent::_prepareColumns();
	}
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}
	protected function CategoryToOptionArray()
	{
		$collection = Mage::getModel('mitacfaq/category')->getCollection();
		$resultArray = array();
		foreach($collection as $category)
		{
			$tempResult[$category->getId()] = $category->getName();
		}
		$resultArray = $tempResult;
		return $resultArray;
	}
}