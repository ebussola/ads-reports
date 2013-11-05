<?php
use ebussola\ads\reports\stats\Stats;

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 12:21
 */

class StatsGen {

    static public function genStats($override=array()) {
        $object_id = rand(0, 1000) . time();
        $name = md5($object_id);
        $time_start = new DateTime('-'.rand(1, 31).' days');
        $time_end = new DateTime('now');
        $clicks = rand(0, 3000);
        $impressions = $clicks * rand(10, 30);
        $cost = $clicks * (rand(10, 120) / 100);

        extract($override);

        return new Stats($object_id, $name, $time_start, $time_end, $clicks, $impressions, $cost);
    }

    static public function genStatsReport() {
        $stats_report = new \ebussola\ads\reports\statsreport\StatsReport();

        $size = rand(50, 200);
        for ($i=0 ; $i<=$size ; $i++) {
            $stats_report->addStats(self::genStats());
        }

        return $stats_report;
    }

    static public function genStatsReportDateRange(\DateTime $time_start, \DateTime $time_end) {
        $stats_report = new \ebussola\ads\reports\statsreport\StatsReport();

        $period = new DatePeriod($time_start, new DateInterval('P1D'), $time_end);
        foreach ($period as $date) {
            $stats_report->addStats(self::genStats(array('time_start' => $date, 'time_end' => new DateTime('now'))));
        }

        return $stats_report;
    }

}