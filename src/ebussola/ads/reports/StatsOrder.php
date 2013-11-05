<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 11:54
 */

namespace ebussola\ads\reports;


class StatsOrder {

    /**
     * @param Stats $a
     * @param Stats $b
     *
     * @return int
     */
    public function time_start(Stats $a, Stats $b) {
        if ($a->time_start == $b->time_start) {
            return 0;
        }

        return $a->time_start < $b->time_start ? -1 : 1;
    }

}