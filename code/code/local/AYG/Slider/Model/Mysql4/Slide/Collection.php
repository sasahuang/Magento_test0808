<?php
class AYG_Slider_Model_Mysql4_Slide_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_eventPrefix    = 'slider_slide_collection';
    protected $_eventObject    = 'collection';
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('slider/slide');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }
    
    protected function _afterLoad()
    {
        
        $items = $this->getColumnValues('slide_id');
        $connection = $this->getConnection();
        if (count($items)) {
            $select = $connection->select()
                    ->from(array('ss'=>$this->getTable('slider/slide_store')))
                    ->where('ss.slide_id IN (?)', $items);
            if ($result = $connection->fetchAll($select)) {
                foreach ($this as $item) {
                    $storeId = false;
                    foreach($result as $pair) {
                        if($pair['slide_id'] == $item->getData('slide_id')) {
                            if ($pair['store_id'] == 0) {
                                $stores = Mage::app()->getStores(false, true);
                                $storeId = current($stores)->getId();
                                //$storeCode = key($stores);
                            } else {
                                $storeId[] = $pair['store_id'];
                            }
                        }
                    }
                    
                    if($storeId)
                        $item->setData('store_id', $storeId);
                }
            }
        }
        
        return parent::_afterLoad();
    }
    
    /**
     * Returns pairs block_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('slide_id', 'title');
    }
    
    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Mage_Cms_Model_Resource_Block_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if($store) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }
            
            if (!is_array($store)) {
                $store = array($store);
            }
        }
        
        if ($withAdmin) {
            $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
        }
        
        $this->addFilter('store', array('in' => $store), 'public');
        
        return $this;
    }
    
    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        
        $countSelect->reset(Zend_Db_Select::GROUP);
        
        return $countSelect;
    }
    
    /**
     * Join store relation table if there is store filter
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('slider/slide_store')),
                'main_table.slide_id = store_table.slide_id',
                array()
            )->group('main_table.slide_id');
            
            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }
}
