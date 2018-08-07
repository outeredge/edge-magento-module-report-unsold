<?php
namespace OuterEdge\ReportUnsoldProducts\Block\Adminhtml\Product;

use Magento\Backend\Block\Widget\Grid\Container;

class Unsold extends Container
{
    /**
     * @var string
     */
    protected $_blockGroup = 'Magento_Reports';

    /**
     * Initialize container block settings
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Magento_Reports';
        $this->_controller = 'adminhtml_product_unsold';
        $this->_headerText = __('Products Unsold');
        parent::_construct();
        $this->buttonList->remove('add');
    }

}