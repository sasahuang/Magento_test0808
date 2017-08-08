<?php
class AYG_Slider_Block_Adminhtml_Slide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setId('slideGrid');
        $this->setDefaultSort('sort_order');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('slider/slide')->getCollection();
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns()
    {
        $this->addColumn('slide_id', array(
            'header'    => Mage::helper('slider')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'slide_id',
        ));
        
        $this->addColumn('title', array(
            'header'    => Mage::helper('slider')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
        
        $this->addColumn('sort_order', array(
            'header'    => Mage::helper('slider')->__('Sort Order'),
            'align'     => 'right',
            'index'     => 'sort_order',
            'width'     => 100,
        ));
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'                    => Mage::helper('adminhtml')->__('Store View'),
                'index'                     => 'store_id',
                'type'                      => 'store',
                'store_all'                 => true,
                'store_view'                => true,
                'width'                     => '200px',
                'sortable'                  => false,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
            ));
        }
        
         $this->addColumn('status', array(
            'header'    => Mage::helper('adminhtml')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => Mage::helper('adminhtml')->__('Enabled'),
                0 => Mage::helper('adminhtml')->__('Disabled'),
            ),
        ));
         
        $this->addColumn('action',
            array(
                'header'=>Mage::helper('adminhtml')->__('Action'),
                'width' => '100',
                'type'=> 'action',
                'getter'=> 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('adminhtml')->__('Edit'),
                        'url' => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'sortable'=> false,
                'index' => 'stores',
                'is_system' => true,
            )
        );
        
        Mage::dispatchEvent('slider_grid_prepare_columns', array('grid' => $this));
        
        $this->addExportType('*/*/exportCsv', Mage::helper('slider')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('slider')->__('XML'));
        
        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('slide_id');
        $this->getMassactionBlock()->setFormFieldName('slide');
        
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('adminhtml')->__('Delete'),
            'url'=> $this->getUrl('*/*/massDelete'),
            'confirm'=> Mage::helper('adminhtml')->__('Are you sure?')
        ));
        
        $statuses = Mage::getSingleton('slider/status')->getOptionArray();
        
        array_unshift($statuses, array('label'=>'', 'value'=>''));
        
        $this->getMassactionBlock()->addItem('status', array(
                'label'=> Mage::helper('adminhtml')->__('Change status'),
                'url'=> $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('adminhtml')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }
    
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
