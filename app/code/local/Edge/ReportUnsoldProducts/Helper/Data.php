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

        $query = "SELECT e.entity_id as id FROM $catalogtableName e WHERE e.entity_id NOT IN (SELECT s1.product_id FROM  $tableNameSales s1) GROUP BY e.entity_id";

        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

        return $data;
    }
}
