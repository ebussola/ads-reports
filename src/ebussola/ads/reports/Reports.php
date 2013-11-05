<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 09:58
 */

namespace ebussola\ads\reports;


class Reports {

    /**
     * Any valid StatsOrder.
     * Each method of this StatsOrder is intended to order a Stats property
     *
     * This class is a DuckType
     */
    private $stats_order;

    public function __construct($stats_order=null) {
        if ($stats_order === null) {
            $stats_order = new StatsOrder();
        }

        $this->stats_order = $stats_order;
    }

    /**
     * @param StatsReport $stats_report
     */
    public function orderStatsReport($property, StatsReport $stats_report) {
        usort($stats_report->stats, array($this->stats_order, $property));
    }

}