<?php
use ebussola\ads\reports\MathHelper;

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 15:11
 */

class StatsReportTest extends PHPUnit_Framework_TestCase {

    public function testUnMutable() {
        $stats_report = StatsGen::genStatsReport();
        $stats_report->clicks = 5000;

        $stats_report->refreshValues();

        $this->assertNotEquals(5000, $stats_report->clicks);
    }

    public function testAddStats() {
        $latest_time_end = new DateTime('now');
        $early_time_start = new DateTime('2013-08-19');

        $stats1 = StatsGen::genStats(array('time_start' => $early_time_start));
        $stats2 = StatsGen::genStats(array('time_end' => $latest_time_end));
        $stats3 = StatsGen::genStats();

        $stats_report = new \ebussola\ads\reports\statsreport\StatsReport();
        $stats_report->addStats($stats1);
        $stats_report->addStats($stats2);
        $stats_report->addStats($stats3);

        $this->assertEquals($stats1->cost + $stats2->cost + $stats3->cost, $stats_report->cost);
        $this->assertEquals($stats1->clicks + $stats2->clicks + $stats3->clicks, $stats_report->clicks);
        $this->assertEquals($stats1->impressions + $stats2->impressions + $stats3->impressions, $stats_report->impressions);
        $this->assertEquals(MathHelper::calcCpc($stats_report->cost, $stats_report->clicks), $stats_report->cpc);
        $this->assertEquals(MathHelper::calcCtr($stats_report->clicks, $stats_report->impressions), $stats_report->ctr);
        $this->assertEquals($early_time_start, $stats_report->time_start);
        $this->assertEquals($latest_time_end, $stats_report->time_end);

        return $stats_report;
    }

    /**
     * @depends testAddStats
     */
    public function testIterableStatsReport($stats_report) {
        foreach ($stats_report as $stats) {
            $this->assertInstanceOf('\ebussola\ads\reports\Stats', $stats);
        }
    }

    public function testPurgeStats() {
        $stats_report = StatsGen::genStatsReport();

        $stats_report2 = clone $stats_report;
        $stats_report2->purgeStats();

        $this->assertNotEquals($stats_report->clicks, $stats_report2->clicks);
        $this->assertNotEquals($stats_report->impressions, $stats_report2->impressions);
        $this->assertNotEquals($stats_report->cost, $stats_report2->cost);
        $this->assertNotEquals($stats_report->cpc, $stats_report2->cpc);
        $this->assertNotEquals($stats_report->ctr, $stats_report2->ctr);
    }

    public function testPurgeStatsOnRefresh() {
        $stats_report = StatsGen::genStatsReport();

        $stats_report2 = clone $stats_report;
        $stats_report2->refreshValues();

        $this->assertEquals($stats_report->clicks, $stats_report2->clicks);
        $this->assertEquals($stats_report->impressions, $stats_report2->impressions);
        $this->assertEquals($stats_report->cost, $stats_report2->cost);
        $this->assertEquals($stats_report->cpc, $stats_report2->cpc);
        $this->assertEquals($stats_report->ctr, $stats_report2->ctr);
    }

}