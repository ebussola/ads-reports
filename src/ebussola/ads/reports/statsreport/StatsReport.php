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

    /**
     * false = OK
     * true = MAYBE CORRUPT
     *
     * @var bool
     */
    public $properties_integrity;

    /**
     * @var \ebussola\ads\reports\Stats[]
     */
    public $stats;

    public function __construct() {
        $this->stats = array();
        $this->properties_integrity = false;
    }

    /**
     * @param \ebussola\ads\reports\Stats $stats
     */
    public function addStats(\ebussola\ads\reports\Stats $stats) {
        $this->stats[] = $stats;

        if ($this->time_start === null || $stats->time_start < $this->time_start) {
            $this->time_start = $stats->time_start;
        }
        if ($this->time_end === null || $stats->time_end > $this->time_end) {
            $this->time_end = $stats->time_end;
        }

        $this->clicks = $this->clicks + $stats->clicks;
        $this->impressions = $this->impressions + $stats->impressions;
        $this->cost = $this->cost + $stats->cost;

        parent::refreshValues();
    }

    public function refreshValues() {
        $statses = $this->stats;
        $this->stats = array();

        foreach ($statses as $stats) {
            $this->addStats($stats);
        }

        parent::refreshValues();
    }

}