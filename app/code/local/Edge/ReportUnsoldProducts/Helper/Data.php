<?php

class Edge_ReportUnsoldProducts_Helper_Data extends Mage_Core_Helper_Abstract
{
   /**
     * get unsold products lists between given date
     * @param type $datefrom
     * @param type $dateto
     * @return type
     */
    public function getUnsoldproductslists($datefrom, $dateto)
    {
        $dateFrom    = new DateTime($datefrom);
        $newdatefrom = $dateFrom->format('Y-m-d');

        $dateTo    = new DateTime($dateto);
        $newdateto = $dateTo->format('Y-m-d');
        
        $resource = Mage::getSingleton('core/resource');

        $catalogtableName = $resource->getTableName('catalog/product');

        $tableNameSales = $resource->getTableName('sales_flat_order_item');

        $tableNameProductEntityInt = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity_int');

        $tableNameEavAttribute = Mage::getSingleton("core/resource")->getTableName('eav_attribute');

        $disabledStatus = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
        
        $query = "SELECT e.entity_id as id FROM $catalogtableName e "
            . "INNER JOIN $tableNameProductEntityInt ei ON e.entity_id=ei.entity_id "
            . "WHERE ei.attribute_id = (SELECT attribute_id FROM $tableNameEavAttribute WHERE attribute_code = 'status' AND source_model = 'catalog/product_status') "
            . "AND ei.value != $disabledStatus "
            . "AND e.entity_id NOT IN (SELECT s1.product_id FROM  $tableNameSales s1 WHERE s1.created_at BETWEEN '".$newdatefrom." 00:00:00' AND '".$newdateto." 23:59:59') "
            . "GROUP BY e.entity_id";

        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

        return $data;
    }
}
