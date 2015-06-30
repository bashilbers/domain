<?php

namespace Domain\Tests\Events;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Aggregates\Basket;
use Domain\Eventing\RedisEventStore;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class RedisEventStoreTest extends \PHPUnit_Framework_TestCase
{
    private $basketId;

    private $store;

    public function setup()
    {
        $this->basketId = BasketId::generate();

        $redis = new \Predis\Client([
            "scheme" => "tcp",
            "host"   => "127.0.0.1",
            "port"   => 6379
        ]);

        try {
            $redis->ping();
        } catch (\Exception $e) {
            $this->markTestSkipped('Redis did not PONG back.. no server running? (' . $e->getMessage() . ')');
        }

        $this->store = new RedisEventStore($redis);

        // create a temporary basket, we need it for testing later
        $basket = Basket::pickup($this->basketId);
        $this->assertEquals(count($basket->getChanges()), 1);

        $this->store->commit($basket->getChanges());
    }

    public function testReconstitutedFeed()
    {
        $basket = Basket::reconstituteFrom($this->store->getAggregateHistoryFor($this->basketId));

        // reconstituted baskets have no changes from the beginning
        $this->assertEquals(count($basket->getChanges()), 0);
    }
}