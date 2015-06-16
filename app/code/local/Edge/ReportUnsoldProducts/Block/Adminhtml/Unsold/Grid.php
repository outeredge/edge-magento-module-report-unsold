<?php

class Edge_ReportUnsoldProducts_Block_Adminhtml_Unsold_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $ids = null;

        $collection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addFieldToFilter('entity_id', 0);

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
                Mage::getSingleton('adminhtml/session')->setFromData($from);
                Mage::getSingleton('adminhtml/session')->setToData($to);

                $collection = Mage::helper('unsold')->getUnsoldproductslists($from, $to);
            }
        }elseif (strpos($this->getRequest()->getActionName(),'export') !== false ||
            array_key_exists('page', $this->getRequest()->getParams()) ||
            array_key_exists('limit', $this->getRequest()->getParams())) {

            $from = Mage::getSingleton('adminhtml/session')->getFromData();
            $to   = Mage::getSingleton('adminhtml/session')->getToData();

            $collection = Mage::helper('unsold')->getUnsoldproductslists($from, $to);
        }

        $this->setCollection($collection);
        $this->getCollection()->getSelect()->group('entity_id');
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            array(
                 'header'   => Mage::helper('unsold')->__('ID'),
                 'sortable' => false,
                 'width'    => '60px',
                 'index'    => 'entity_id',
            )
        );
        $this->addColumn(
            'name',
            array(
                 'header' => Mage::helper('unsold')->__('Name'),
                 'index'  => 'name',
                 'sortable' => false,
            )
        );
        $this->addColumn(
            'views',
            array(
                 'header' => Mage::helper('unsold')->__('Views'),
                 'width'    => '60px',
                 'sortable' => false,
                 'index'  => 'views',
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
