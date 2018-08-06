<?php
namespace OuterEdge\ReportUnsoldProducts\Controller\Adminhtml\Product;

use Magento\Backend\Block\Widget\Grid\ExportInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Reports\Controller\Adminhtml\Report\Product As ProductReport;

class ExportUnsoldCsv extends ProductReport
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'OuterEdge_ReportUnsoldProducts::unsold';

    /**
     * Export Unsold Products report to CSV format action
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $fileName = 'products_unsold.csv';
        /** @var ExportInterface $exportBlock */
        $exportBlock = $this->_view->getLayout()->getChildBlock('adminhtml.report.grid', 'grid.export');
        return $this->_fileFactory->create(
            $fileName,
            $exportBlock->getCsvFile(),
            DirectoryList::VAR_DIR
        );
    }
}