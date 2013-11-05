<?php
use ebussola\ads\reports\stats\Stats;

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 12:06
 */

class ReportsTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Stats
     */
    private $stats;

    public function setUp() {
        $this->stats = StatsGen::genStats();
    }

    public function testOrderStatsReport() {
        $stats_order = new \ebussola\ads\reports\StatsOrder();
        $reports = new \ebussola\ads\reports\Reports($stats_order);

        $stats_report = StatsGen::genStatsReport();
        $duplicated_stats_report = clone $stats_report;

        $reports->orderStatsReport('time_start', $stats_report);

        $this->assertCount(count($stats_report->stats), $duplicated_stats_report->stats);
        $this->assertNotEquals($stats_report->stats, $duplicated_stats_report->stats);
    }

}