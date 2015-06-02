<?php

class Edge_ReportUnsoldProducts_Block_Adminhtml_Unsold_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $productsId = Mage::helper('unsold')->getUnsoldproductslists();

        $ids = array();
        foreach ($productsId as $prodId) {
            $ids[] = $prodId['id'];
        }

        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name');
        $this->setCollection($collection);

        $collection->addAttributeToFilter('entity_id', array('in' => $ids));

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            array(
                 'header'   => Mage::helper('unsold')->__('ID'),
                 'sortable' => true,
                 'width'    => '60px',
                 'index'    => 'entity_id',
            )
        );
        $this->addColumn(
            'name',
            array(
                 'header' => Mage::helper('unsold')->__('Name'),
                 'index'  => 'name',
            )
        );
        $this->addColumn('created_at',
            array(
                'header' => Mage::helper('unsold')->__('Date'),
                'index'  => 'created_at',
                'type'   => 'datetime',
                'width'  => '200px',
            )
        );
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('unsold')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'    => Mage::helper('unsold')->__('Edit'),
                        'url'        => array(
                            'base'   => '*/catalog_product/edit',
                            'params' => array('store' => $this->getRequest()->getParam('store'))
                        ),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system'   => true,
        ));

        $this->addExportType('*/*/exportUnsoldCsv', Mage::helper('unsold')->__('CSV'));
        $this->addExportType('*/*/exportUnsoldExcel', Mage::helper('unsold')->__('Excel XML'));

        return parent::_prepareColumns();
   }
}
