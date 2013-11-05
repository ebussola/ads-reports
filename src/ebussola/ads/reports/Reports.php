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

    /**
     * Any valid StatsFinder.
     * Every method must have two attributes: StatsReport and the value to be founded
     *
     * This class is a DuckType
     */
    private $stats_finder;

    public function __construct($stats_order=null, $stats_finder=null) {
        if ($stats_order === null) {
            $stats_order = new StatsOrder();
        }
        if ($stats_finder === null) {
            $stats_finder = new StatsFinder();
        }

        $this->stats_order = $stats_order;
        $this->stats_finder = $stats_finder;
    }

    /**
     * @param StatsReport $stats_report
     */
    public function orderStatsReport($property, StatsReport $stats_report) {
        usort($stats_report->stats, array($this->stats_order, $property));
    }

    /**
     * @param \DateTime $time_start
     * @param \DateTime $time_end
     *
     * @return \ebussola\ads\reports\StatsReport
     */
    public function sliceStatsReport(StatsReport $stats_report, \DateTime $time_start, \DateTime $time_end) {
        $this->orderStatsReport('time_start', $stats_report);

        $start_key = $this->findStatsKeyByDateTime($stats_report, $time_start);
        $end_key = $this->findStatsKeyByDateTime($stats_report, $time_end);

        $lenght = ($end_key - $start_key) + 1; //caution, this works only if the sequence is ok
        $sliced_stats = array_slice($stats_report->stats, $start_key, $lenght);

        $result = clone $stats_report;
        $result->stats = array();
        foreach ($sliced_stats as $_stats) {
            $result->addStats($_stats);
        }

        return $result;
    }

    /**
     * @param string      $find_by
     * @param mixed       $value
     * @param StatsReport $stats_report
     *
     * @return Stats | StatsReport
     */
    public function findStats($find_by, $value, StatsReport $stats_report) {
        return call_user_func_array(array($this->stats_finder, $find_by), array($stats_report, $value));
    }

    /**
     * @param \DateTime $datetime
     *
     * @return int
     */
    private function findStatsKeyByDateTime(StatsReport $stats_report, \DateTime $datetime) {
        $stats1 = $this->findStats('time_start', $datetime, $stats_report);

        foreach ($stats_report->stats as $key => $stats2) {
            if ($stats1 == $stats2) {
                return $key;
            }
        }

        return null;
    }

}