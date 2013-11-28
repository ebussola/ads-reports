<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 04/11/13
 * Time: 18:32
 */

namespace ebussola\ads\reports;

/**
 * Interface Stats
 * @package ebussola\ads\reports
 *
 * @property string $object_id
 * @property string $name
 * @property \DateTime $time_start
 * @property \DateTime $time_end
 * @property int $clicks
 * @property int $impressions
 * @property float $cost
 * @property float $cpc
 * @property float $ctr
 */
interface Stats {

    /**
     * @param Stats $stats
     *
     * @return Stats
     */
    public function merge(Stats $stats);

    /**
     * refresh calculable values (like ctr and cpc) with the actual values
     */
    public function refreshValues();

}