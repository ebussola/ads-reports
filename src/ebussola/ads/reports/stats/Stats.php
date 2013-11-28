<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 10:20
 */

namespace ebussola\ads\reports\stats;


use ebussola\ads\reports\MathHelper;

class Stats implements \ebussola\ads\reports\Stats {

    /**
     * @var string
     */
    public $object_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var \DateTime
     */
    public $time_start;

    /**
     * @var \DateTime
     */
    public $time_end;

    /**
     * @var int
     */
    public $clicks;

    /**
     * @var int
     */
    public $impressions;

    /**
     * @var float
     */
    public $cost;

    /**
     * @var float
     */
    public $cpc;

    /**
     * @var float
     */
    public $ctr;

    /**
     * @param Stats $stats
     *
     * @return Stats
     */
    public function merge(\ebussola\ads\reports\Stats $stats) {
        $this->clicks = $this->clicks + $stats->clicks;
        $this->impressions = $this->impressions + $stats->impressions;
        $this->cost = $this->cost + $stats->cost;

        if ($stats->time_start < $this->time_start) {
            $this->time_start = $stats->time_start;
        }
        if ($stats->time_end > $this->time_end) {
            $this->time_end = $stats->time_end;
        }

        $this->refreshValues();
    }

    /**
     * Sets the calculable values, based on values already setted
     */
    public function refreshValues() {
        $this->cpc = MathHelper::calcCpc($this->cost, $this->clicks);
        $this->ctr = MathHelper::calcCtr($this->clicks, $this->impressions);
    }

}