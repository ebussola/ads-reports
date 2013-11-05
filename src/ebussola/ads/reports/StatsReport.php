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
interface StatsReport extends Stats {

    /**
     * @param Stats $stats
     */
    public function addStats(Stats $stats);

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function get($property);

    /**
     * @param string $property
     * @param mixed  $value
     */
    public function set($property, $value);

}