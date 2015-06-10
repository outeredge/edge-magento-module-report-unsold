<?php

class Edge_ReportUnsoldProducts_Block_Adminhtml_Unsold extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'unsold';
        $this->_controller = 'adminhtml_unsold';
        $this->_headerText = Mage::helper('unsold')->__('Products Unsold');
        parent::__construct();
        $this->_removeButton('add');
        $this->setTemplate('edge/reportunsoldproducts/container.phtml');
    }
}
