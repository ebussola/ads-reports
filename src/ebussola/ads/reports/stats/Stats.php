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
     * @param string    $object_id
     * @param string    $name
     * @param \DateTime $time_start
     * @param \DateTime $time_end
     * @param int       $clicks
     * @param int       $impressions
     * @param float     $cost
     */
    public function __construct($object_id, $name, $time_start, $time_end, $clicks, $impressions, $cost) {
        $this->object_id = $object_id;
        $this->name = $name;
        $this->time_start = $time_start;
        $this->time_end = $time_end;
        $this->clicks = $clicks;
        $this->impressions = $impressions;
        $this->cost = $cost;

        $this->refreshValues();
    }

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
    protected function refreshValues() {
        $this->cpc = MathHelper::calcCpc($this->cost, $this->clicks);
        $this->ctr = MathHelper::calcCtr($this->clicks, $this->impressions);
    }

}