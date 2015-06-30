<?php

namespace Domain\Tests\Events;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Identity\ProductId;
use Domain\Tests\Fixtures\Aggregates\Basket;
use Domain\Eventing\FileEventStore;

use Symfony\Component\Finder\Finder;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class FileEventStoreTest extends \PHPUnit_Framework_TestCase
{
    private $path;

    private $basketId;

    private $store;

    public function setup()
    {
        $this->path = __DIR__ . '/../Fixtures/Stores/events';

        $this->basketId = BasketId::generate();

        $this->store = new FileEventStore($this->path);

        // create a temporary basket, we need it for testing later
        $basket = Basket::pickup($this->basketId);

        $basket->addProduct(ProductId::generate());
        $basket->addProduct(ProductId::generate());
        $basket->addProduct(ProductId::generate());

        // 1 time "pickup" + 3 times "add product"
        $this->assertEquals(count($basket->getChanges()), 4);

        $this->store->commit($basket->getChanges());
    }

    public function testReconstitute()
    {
        $basket = Basket::reconstituteFrom($this->store->getAggregateHistoryFor($this->basketId));

        // no changes recorded
        $this->assertEquals(count($basket->getChanges()), 0);

        // must be matching
        $this->assertEquals($basket->getProductCount(), 3);
    }

    public function tearDown()
    {
        echo "\nRemoving events from disk...\n";
        $finder = new Finder();
        $stores = $finder->files()->in($this->path);
        foreach($stores as $store) {
            echo "Removing store {$store->getFilename()}\n";
            @unlink($store->getPathName());
        }
    }
}