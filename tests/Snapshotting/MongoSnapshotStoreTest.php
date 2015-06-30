<?php

namespace Domain\Tests\Snapshotting;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Aggregates\Basket;
use Domain\Tests\Fixtures\Repository\BasketRepository;
use Domain\Aggregates\MongoSnapshotStore;
use Domain\Eventing\NullEventStore;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class MongoSnapshotStoreTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        try {
            $mongo = new \MongoClient('mongodb://localhost');
            $db = $mongo->selectDb('test');
        } catch (\Exception $e) {
            $this->markTestSkipped('Mongo connection error.. no server running? (' . $e->getMessage() . ')');
        }

        $this->store = new MongoSnapshotStore($db);
    }

    public function testSaveStateDirectlyToStore()
    {
        $id = BasketId::generate();
        $basket = Basket::pickup($id);

        // save snapshot
        $this->store->save($basket);

        // retrieve snapshot
        $snapshot = $this->store->get($id);

        // compare identity
        $this->assertEquals($id, $snapshot->getIdentity());

        // the events must still exists on the snapshot
        $this->assertTrue($snapshot->hasChanges());
        $this->assertEquals(1, count($snapshot->getChanges())); // pickup event
    }

    public function testSaveStateWithChangeshandled()
    {
        $repo = new BasketRepository(new NullEventStore, $this->store);

        $id = BasketId::generate();
        $basket = Basket::pickup($id);

        // save snapshot
        $repo->saveSnapshot($basket);

        // retrieve snapshot
        $snapshot = $repo->loadSnapshot($id);

        // the events must have been processed before save
        $this->assertFalse($snapshot->hasChanges());
        $this->assertEquals(0, count($snapshot->getChanges()));
    }
}