<?php

class Edge_ReportUnsoldProducts_Adminhtml_UnsoldController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
             ->_title($this->__('outer/edge'))
             ->_title($this->__('Products Unsold'))
             ->_setActiveMenu('edge');
        return $this;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            Mage::getSingleton('adminhtml/session')->setFrom($this->getRequest()->getParam('report_from'));
            Mage::getSingleton('adminhtml/session')->setTo($this->getRequest()->getParam('report_to'));
        } elseif (count($this->getRequest()->getParams()) == 1) {
            Mage::getSingleton('adminhtml/session')->setFrom('');
            Mage::getSingleton('adminhtml/session')->setTo('');
        }
        
        $this->_initAction()
             ->_addBreadcrumb(Mage::helper('unsold')->__('Products Unsold'), Mage::helper('unsold')->__('Products Unsold'))
             ->_addContent($this->getLayout()->createBlock('unsold/adminhtml_unsold'))
             ->renderLayout();
    }

    /**
     * Export Unsold Products report to CSV format action
     */
    public function exportUnsoldCsvAction()
    {
        $fileName = 'products_unsold.csv';
        $content  = $this->getLayout()
            ->createBlock('unsold/adminhtml_unsold_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export Unsold Products report to XML format action
     */
    public function exportUnsoldExcelAction()
    {
        $fileName = 'products_unsold.xml';
        $content = $this->getLayout()
            ->createBlock('unsold/adminhtml_unsold_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }
}
