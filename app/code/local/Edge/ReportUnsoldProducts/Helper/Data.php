<?php

class Edge_ReportUnsoldProducts_Helper_Data extends Mage_Core_Helper_Abstract
{
   /**
     * get unsold products lists between given date
     * @param type $dateFrom
     * @param type $dateTo
     * @return type
     */
    public function getUnsoldproductslists($dateFrom, $dateTo)
    {
        $from        = explode('/', $dateFrom);
        $newDateFrom = $from[2] . '/' . $from[1] . '/' . $from[0] . ' 00:00:00';
        $to          = explode('/', $dateTo);
        $newDateTo   = $to[2] . '/' . $to[1] . '/' . $to[0] . ' 23:59:59';

        $resource                  = Mage::getSingleton('core/resource');
        $catalogtableName          = $resource->getTableName('catalog/product');
        $tableNameSales            = $resource->getTableName('sales_flat_order_item');
        $tableNameProductEntityInt = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity_int');
        $tableNameEavAttribute     = Mage::getSingleton("core/resource")->getTableName('eav_attribute');
        $disabledStatus            = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;

        $query = "SELECT e.entity_id as id FROM $catalogtableName e "
            . "INNER JOIN $tableNameProductEntityInt ei ON e.entity_id=ei.entity_id "
            . "WHERE ei.attribute_id = (SELECT attribute_id FROM $tableNameEavAttribute WHERE attribute_code = 'status' AND source_model = 'catalog/product_status') "
            . "AND ei.value != $disabledStatus "
            . "AND e.entity_id NOT IN (SELECT s1.product_id FROM  $tableNameSales s1 WHERE s1.created_at BETWEEN '".$newDateFrom."' AND '".$newDateTo."') "
            . "GROUP BY e.entity_id";

        $productIds = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

        $reportEvenProduvtView = Mage_Reports_Model_Event::EVENT_PRODUCT_VIEW;
        $catalogProductTypeId  = Mage::getModel('eav/entity_type')->loadByCode('catalog_product');

        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->joinTable(
                    array('re' => 'report_event'),
                    'object_id  = entity_id ',
                    array('views' => 'COUNT(re.event_id)'),
                    "event_type_id = $reportEvenProduvtView AND logged_at >= '".$newDateFrom."' AND logged_at <= '".$newDateTo."'",
                    'left'
                )
            ->addAttributeToFilter('entity_id', array('in' => $productIds))
            ->addAttributeToFilter('entity_type_id', array('eq' => $catalogProductTypeId['entity_type_id']));

        return $collection;
    }
}
