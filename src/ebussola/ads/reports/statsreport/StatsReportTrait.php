<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 20/02/14
 * Time: 14:59
 */

namespace ebussola\ads\reports\statsreport;


trait StatsReportTrait {

    /**
     * @var \ebussola\ads\reports\Stats[]
     */
    public $stats;

    public function __construct() {
        $this->stats = array();
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

    /**
     * @return void
     */
    public function purgeStats() {
        $this->stats = array();

        $this->time_start = null;
        $this->time_end = null;
        $this->clicks = null;
        $this->impressions = null;
        $this->cost = null;
        $this->cpc = null;
        $this->ctr = null;
    }

    public function refreshValues() {
        $statses = $this->stats;
        $this->purgeStats();

        foreach ($statses as $stats) {
            $this->addStats($stats);
        }

        parent::refreshValues();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current() {
        return current($this->stats);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next() {
        next($this->stats);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key() {
        return key($this->stats);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() {
        return ($this->current() !== false);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind() {
        reset($this->stats);
    }

} 