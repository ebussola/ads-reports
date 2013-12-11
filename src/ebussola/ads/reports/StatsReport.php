<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 11:39
 */

namespace ebussola\ads\reports;

/**
 * Interface StatsReport
 * @package ebussola\ads\reports
 *
 * @property Stats[] $stats
 */
interface StatsReport extends Stats, \Iterator {

    /**
     * @param Stats $stats
     */
    public function addStats(Stats $stats);

    /**
     * @return void
     */
    public function purgeStats();

}