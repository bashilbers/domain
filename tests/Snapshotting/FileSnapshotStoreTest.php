<?php

namespace Domain\Tests\Snapshotting;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Identity\ProductId;
use Domain\Tests\Fixtures\Aggregates\Basket;
use Domain\Snapshotting\FileSnapshotStore;

use Symfony\Component\Finder\Finder;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class FileSnapshotStoreTest extends \PHPUnit_Framework_TestCase
{
    private $basketId;

    private $path;

    private $store;

    public function setup()
    {
        $this->path = __DIR__ . '/../Fixtures/Stores/snapshots';
        $this->basketId = BasketId::generate();
        $basket = Basket::pickup($this->basketId);
        $this->store = new FileSnapshotStore($this->path);

        $basket->addProduct(ProductId::generate());

        $this->store->save($basket);
    }

    public function testGetSnapshot()
    {
        $snapshot = $this->store->get($this->basketId);
        $aggregate = $snapshot->getAggregate();

        $this->assertEquals($aggregate->getProductCount(), 1);
    }

    public function tearDown()
    {
        echo "\nRemoving snapshots from disk...\n";
        $finder = new Finder();
        $stores = $finder->files()->in($this->path);
        foreach($stores as $store) {
            echo "Removing store {$store->getFilename()}\n";
            @unlink($store->getPathName());
        }
    }
}