<?php

namespace OuterEdge\ReportUnsoldProducts\Controller\Adminhtml\Product;

use Magento\Reports\Controller\Adminhtml\Report\Product as ProductReport;

class Unsold extends ProductReport
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'OuterEdge_ReportUnsoldProducts::unsold';


    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_setActiveMenu('OuterEdge_ReportUnsoldProducts::report_products_unsold'
        )->_addBreadcrumb(
            __('Products Not Sold'),
            __('Products Not Sold')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Unsold Products Report'));
        $this->_view->renderLayout();
    }
}