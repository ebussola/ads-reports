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

    public function testGroupByDate() {
        $stats_reports = array();
        $stats_reports[1] = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $stats_reports[2] = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $stats_reports[3] = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));

        $main_report = new \ebussola\ads\reports\statsreport\StatsReport();
        foreach ($stats_reports as $stats_report) {
            foreach ($stats_report as $stats) {
                $main_report->addStats($stats);
            }
        }

        $this->assertCount(87, $main_report->stats);

        $this->reports->groupBy('date', $main_report);
        $this->assertCount(29, $main_report->stats);
    }

    public function testGroupByMonth() {
        $stats_reports = array();
        $stats_reports[1] = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $stats_reports[2] = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $stats_reports[3] = StatsGen::genStatsReportDateRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));

        $stats_reports[4] = StatsGen::genStatsReportDateRange(new DateTime('2013-09-01'), new DateTime('2013-09-30'));
        $stats_reports[5] = StatsGen::genStatsReportDateRange(new DateTime('2013-09-01'), new DateTime('2013-09-30'));
        $stats_reports[6] = StatsGen::genStatsReportDateRange(new DateTime('2013-09-01'), new DateTime('2013-09-30'));

        $main_report = new \ebussola\ads\reports\statsreport\StatsReport();
        foreach ($stats_reports as $stats_report) {
            foreach ($stats_report as $stats) {
                $main_report->addStats($stats);
            }
        }

        $this->assertCount(174, $main_report->stats);

        $this->reports->groupBy('month', $main_report);
        $this->assertCount(2, $main_report->stats);
    }

    public function testGroupByHour() {
        $stats_reports = array();
        $stats_reports[1] = StatsGen::genStatsReportHourRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $stats_reports[2] = StatsGen::genStatsReportHourRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));
        $stats_reports[3] = StatsGen::genStatsReportHourRange(new DateTime('2013-10-01'), new DateTime('2013-10-30'));

        $stats_reports[4] = StatsGen::genStatsReportHourRange(new DateTime('2013-09-01'), new DateTime('2013-09-30'));
        $stats_reports[5] = StatsGen::genStatsReportHourRange(new DateTime('2013-09-01'), new DateTime('2013-09-30'));
        $stats_reports[6] = StatsGen::genStatsReportHourRange(new DateTime('2013-09-01'), new DateTime('2013-09-30'));

        $main_report = new \ebussola\ads\reports\statsreport\StatsReport();
        foreach ($stats_reports as $stats_report) {
            foreach ($stats_report as $stats) {
                $main_report->addStats($stats);
            }
        }

        $this->assertCount(4173, $main_report->stats);

        $this->reports->groupBy('hour', $main_report);
        $this->assertCount(24, $main_report->stats);
    }

}