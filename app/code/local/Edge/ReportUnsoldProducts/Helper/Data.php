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

        $query = "SELECT e.entity_id as id FROM $catalogtableName e WHERE e.entity_id NOT IN (SELECT s1.product_id FROM  $tableNameSales s1 where s1.created_at BETWEEN '".$newdatefrom." 00:00:00' AND '".$newdateto." 23:59:59') GROUP BY e.entity_id";

        $data = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($query);

        return $data;
    }
}
