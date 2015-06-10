<?php

class Edge_ReportUnsoldProducts_Block_Adminhtml_Unsold_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $ids  = null;

        if ($this->getRequest()->isPost()) {
            $flag = true;
            $from = $this->getRequest()->getParam('report_from');
            $to   = $this->getRequest()->getParam('report_to');

            if ($from == "") {
                $flag = false;
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('unsold')->__('Please select date From'));
            }
            if ($to == "") {
                $flag = false;
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('unsold')->__('Please select date To'));
            }
            if ($flag) {
                $ids = Mage::helper('unsold')->getUnsoldproductslists($from, $to);
            }
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

    public function getMainButtonsHtml()
    {
        return '';
    }
}
