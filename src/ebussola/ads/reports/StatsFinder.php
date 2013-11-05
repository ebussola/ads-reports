<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 14:41
 */

namespace ebussola\ads\reports;

class StatsFinder {

    /**
     * @param StatsReport $stats_report
     * @param \DateTime   $time_start
     *
     * @return Stats
     */
    public function time_start(StatsReport $stats_report, \DateTime $time_start) {
        foreach ($stats_report->stats as $stats) {
            if ($time_start->getTimestamp() == $stats->time_start->getTimestamp()) {
                return $stats;
            }
        }

        return null;
    }

} 