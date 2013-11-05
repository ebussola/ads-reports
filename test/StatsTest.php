<?php
use ebussola\ads\reports\stats\Stats;

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 05/11/13
 * Time: 11:25
 */

class StatsTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Stats
     */
    private $stats;

    public function setUp() {
        $this->stats = new Stats(1, 'Teste do Stats', new DateTime('-5 days'), new DateTime('now'), 876, 393372, 1528.09);
    }

    public function testInstantiateStats() {
        $this->assertNotNull($this->stats->cpc);
        $this->assertNotNull($this->stats->ctr);
    }

    public function testMerge() {
        $time_start = new DateTime('-6 days');
        $stats2 = new Stats(1, 'Teste de Merge', $time_start, new DateTime('-1 day'), 100, 2000, 234.80);

        $this->stats->merge($stats2);

        $now = new DateTime('now');
        $this->assertEquals($time_start->getTimestamp(), $this->stats->time_start->getTimestamp());
        $this->assertEquals($now->getTimestamp(), $this->stats->time_end->getTimestamp());
        $this->assertEquals(976, $this->stats->clicks);
        $this->assertEquals(395372, $this->stats->impressions);
        $this->assertEquals(1762.89, $this->stats->cost);
        $this->assertEquals(1.8062397540984, $this->stats->cpc);
        $this->assertEquals(0.24685612537054, $this->stats->ctr);
    }

}
 