<?php

namespace OuterEdge\ReportUnsoldProducts\Model\ResourceModel\Product\Unsold;

use Magento\Reports\Model\ResourceModel\Product\Collection as ProductCollection;

class Collection extends ProductCollection
{

    /**
     * Set Date range to collection
     *
     * @param int $from
     * @param int $to
     * @return $this
     */
    public function setDateRange($from, $to)
    {
        $this->_reset()->addAttributeToSelect(
            '*'
        )->addSoldProducts(
            $from,
            $to
        );
        return $this;
    }

    /**
     * Add addUnOrderedProduct
     *
     * @param string $from
     * @param string $to
     * @return $this
     */
    public function addSoldProducts($from = '', $to = '')
    {
        //Getting product ids from order items which are sold, with in the period.
        $orderSelect = "SELECT  DISTINCT `order_items`.`product_id` FROM `sales_order_item` AS `order_items`
                        INNER JOIN `sales_order` AS `order` ON  `order`.`entity_id`= `order_items`.`order_id` 
                        WHERE `order`.`status`!='canceled' AND `order`.`created_at` BETWEEN '$from' AND '$to'";

        //Getting product name, product id and sku for the grid from catalog product, which are not in the product id's which are sold.
        $this->getSelect()->reset()->from(
            ['product_varchar' => $this->getTable('catalog_product_entity_varchar')],
            [
                'product_name' => 'product_varchar.value',
                'product_id' => 'catalog_product.entity_id',
                'product_sku' => 'catalog_product.sku'
            ]
        )->joinInner(
            ['catalog_product' => $this->getTable('catalog_product_entity')],
            []
        )->where(
            'product_varchar.entity_id = catalog_product.entity_id'
        )->where(
            'product_varchar.attribute_id = 73'
        )->where('catalog_product.entity_id NOT IN(' . $orderSelect . ')');

        return $this;
    }

    /**
     * Set store filter to collection, this function need to be done.
     *
     * @param array $storeIds
     * @return $this
     */
    public function setStoreIds($storeIds)
    {
        if ($storeIds) {
            //$this->getSelect()->where('sales_order.store_id IN (?)', (array)$storeIds);
        }
        return $this;
    }
}