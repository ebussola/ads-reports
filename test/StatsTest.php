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
        $this->stats = new Stats();
        $this->stats->object_id = 1;
        $this->stats->name = 'Teste do Stats';
        $this->stats->time_start = new DateTime('-5 days');
        $this->stats->time_end = new DateTime('now');
        $this->stats->clicks = 876;
        $this->stats->impressions = 393372;
        $this->stats->cost = 1528.09;
        $this->stats->refreshValues();
    }

    public function testInstantiateStats() {
        $this->assertNotNull($this->stats->cpc);
        $this->assertNotNull($this->stats->ctr);
    }

    public function testMerge() {
        $time_start = new \DateTime('-6 days');
        $stats2 = new Stats();
        $stats2->object_id = 1;
        $stats2->name = 'Teste de Merge';
        $stats2->time_start = $time_start;
        $stats2->time_end = new \DateTime('-1 day');
        $stats2->clicks = 100;
        $stats2->impressions = 2000;
        $stats2->cost = 234.80;

        $this->stats->merge($stats2);

        $now = new \DateTime('now');
        $this->assertEquals($time_start->getTimestamp(), $this->stats->time_start->getTimestamp());
        $this->assertEquals($now->getTimestamp(), $this->stats->time_end->getTimestamp());
        $this->assertEquals(976, $this->stats->clicks);
        $this->assertEquals(395372, $this->stats->impressions);
        $this->assertEquals(1762.89, $this->stats->cost);
        $this->assertEquals(1.8062397540984, $this->stats->cpc);
        $this->assertEquals(0.24685612537054, $this->stats->ctr);
    }

}
 