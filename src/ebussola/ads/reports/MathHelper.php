<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 10:24
 */

namespace ebussola\ads\reports;


class MathHelper {

    /**
     * @param float $cost
     * @param int   $clicks
     *
     * @return float
     */
    static public function calcCpc($cost, $clicks) {
        $result = null;

        if ($cost > 0 && $clicks > 0) {
            $result = $cost / $clicks;
        } else {
            $result = (float) 0;
        }

        return $result;
    }

    /**
     * @param int $clicks
     * @param int $impressions
     *
     * @return float
     */
    static public function calcCtr($clicks, $impressions) {
        $result = null;

        if ($clicks > 0 && $impressions > 0) {
            $div = $clicks / $impressions;
            $result = $div * 100;
        } else {
            $result = (float) 0;
        }

        return $result;
    }

}