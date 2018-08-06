<?php

namespace OuterEdge\ReportUnsoldProducts\Model\ResourceModel\Product\Unsold\Collection;

use Magento\Reports\Model\ResourceModel\Report\Collection as ReportCollection;

class Initial extends ReportCollection
{
    /**
     * Report sub-collection class name
     *
     * @var string
     */
    protected $_reportCollection = \OuterEdge\ReportUnsoldProducts\Model\ResourceModel\Product\Unsold\Collection::class;
}