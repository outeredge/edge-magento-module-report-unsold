<?php

class Edge_ReportUnsoldProducts_Adminhtml_UnsoldController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
             ->_title($this->__('outer/edge'))
             ->_title($this->__('Unsold Products'))
             ->_setActiveMenu('edge');
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function postAction()
    {
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

        $this->loadLayout();
        $this->renderLayout();
    }
}
