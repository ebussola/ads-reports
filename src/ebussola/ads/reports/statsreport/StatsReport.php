<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 13:33
 */

namespace ebussola\ads\reports\statsreport;


use ebussola\ads\reports\stats\Stats;

class StatsReport extends Stats implements \ebussola\ads\reports\StatsReport {

    public function __construct() {
        $this->stats = array();
    }

    /**
     * @param \ebussola\ads\reports\Stats $stats
     */
    public function addStats(\ebussola\ads\reports\Stats $stats) {
        $this->stats[] = $stats;
    }

}