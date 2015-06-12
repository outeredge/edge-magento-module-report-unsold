<?php

class Edge_ReportUnsoldProducts_Helper_Data extends Mage_Core_Helper_Abstract
{
   /**
     * get unsold products lists between given date
     * @return type
     */
    public function getUnsoldproductslists()
    {
        $resource = Mage::getSingleton('core/resource');

        $catalogtableName = $resource->getTableName('catalog/product');

        $tableNameSales = $resource->getTableName('sales_flat_order_item');

        $tableNameProductEntityInt = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity_int');

        $tableNameEavAttribute = Mage::getSingleton("core/resource")->getTableName('eav_attribute');

        $disabledStatus = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
        
        $query = "SELECT e.entity_id as id FROM $catalogtableName e "
            . "INNER JOIN $tableNameProductEntityInt ei ON e.entity_id=ei.entity_id "
            . "WHERE ei.attribute_id = (SELECT attribute_id FROM $tableNameEavAttribute WHERE attribute_code = 'status') "
            . "AND ei.value != $disabledStatus "
            . "AND e.entity_id NOT IN (SELECT s1.product_id FROM  $tableNameSales s1) GROUP BY e.entity_id";

        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

        return $data;
    }
}
