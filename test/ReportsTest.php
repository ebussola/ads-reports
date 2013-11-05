<?php

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 12:06
 */

class ReportsTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \ebussola\ads\reports\Reports
     */
    private $reports;

    public function setUp() {
        $stats_order = new \ebussola\ads\reports\StatsOrder();
        $this->reports = new \ebussola\ads\reports\Reports($stats_order);
    }

    public function testOrderStatsReport() {
        $stats_report = StatsGen::genStatsReport();
        $duplicated_stats_report = clone $stats_report;

        $this->reports->orderStatsReport('time_start', $stats_report);

        $this->assertCount(count($stats_report->stats), $duplicated_stats_report->stats);
        $this->assertNotEquals($stats_report->stats, $duplicated_stats_report->stats);
    }

    public function testSliceStatsReport() {
        $stats_report = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $sliced = $this->reports->sliceStatsReport($stats_report, new DateTime('2013-10-10'), new DateTime('2013-10-20'));

        $this->assertCount(11, $sliced->stats);
        $this->assertEquals('2013-10-10', $sliced->stats[0]->time_start->format('Y-m-d'));
        $this->assertEquals('2013-10-20', $sliced->stats[10]->time_start->format('Y-m-d'));
    }

    public function testFindStats() {
        $stats_report = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $stats = $this->reports->findStats('time_start', new DateTime('2013-10-15'), $stats_report);

        $this->assertEquals('2013-10-15', $stats->time_start->format('Y-m-d'));
    }

}