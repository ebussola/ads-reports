<?php
use ebussola\ads\reports\stats\Stats;

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 12:21
 */

class StatsGen {

    static public function genStats() {
        $object_id = rand(0, 1000) . time();
        $name = md5($object_id);
        $time_start = new DateTime('-'.rand(1, 31).' days');
        $time_end = new DateTime('now');
        $clicks = rand(0, 3000);
        $impressions = $clicks * rand(5, 8);
        $cost = $clicks * (rand(10, 120) / 100);

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

}