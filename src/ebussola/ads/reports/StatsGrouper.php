<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/12/13
 * Time: 14:50
 */

namespace ebussola\ads\reports;


use ebussola\ads\reports\statsreport\StatsReport;

class StatsGrouper {

    /**
     * @param StatsReport | Stats[] $stats_report
     */
    public function date(StatsReport $stats_report) {
        /** @var Stats[] $stats_date */
        $stats_date = array();
        foreach ($stats_report as $stats) {
            $key_date = $stats->time_start->format('dmY');

            if (isset($stats_date[$key_date])) {
                $stats_date[$key_date]->merge($stats);
            } else {
                $stats_date[$key_date] = clone $stats;
            }
        }

        $stats_report->purgeStats();
        foreach ($stats_date as $stats) {
            $stats_report->addStats($stats);
        }

        return $stats_report;
    }

}