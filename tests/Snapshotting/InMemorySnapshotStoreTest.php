<?php

namespace Domain\Tests\Snapshotting;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Identity\ProductId;
use Domain\Tests\Fixtures\Aggregates\Basket;
use Domain\Snapshotting\InMemorySnapshotStore;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class InMemorySnapshotStoreTestextends extends \PHPUnit_Framework_TestCase
{
    private $basketId;

    private $store;

    public function setup()
    {
        $this->basketId = BasketId::generate();
        $basket = Basket::pickup($this->basketId);
        $this->store = new InMemorySnapshotStore;

        $basket->addProduct(ProductId::generate());

        $this->store->save($basket);
    }

    public function testGetSnapshot()
    {
        $snapshot = $this->store->get($this->basketId);
        $aggregate = $snapshot->getAggregate();

        $this->assertEquals($aggregate->getProductCount(), 1);
    }
}