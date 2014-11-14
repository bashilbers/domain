<?php

namespace Domain\Tests\Events;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Identity\ProductId;
use Domain\Tests\Fixtures\Aggregates\Basket;
use Domain\Events\MySqlEventStore;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class MysqlEventStoreTest extends \PHPUnit_Framework_TestCase
{
    private $basketId;

    private $store;

    public function setup()
    {
        $this->basketId = BasketId::generate();

        $pdo = new \PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'admindev');
        $this->store = new MySqlEventStore($pdo);

        // create a temporary basket, we need it for testing later
        $basket = Basket::pickup($this->basketId);
        $this->assertEquals(count($basket->getChanges()), 1);

        $basket->addProduct(ProductId::generate());
        $this->assertEquals(count($basket->getChanges()), 2);

        $this->store->commit($basket->getChanges());
    }

    public function testReconstitutedBasket()
    {
        $basket = Basket::reconstituteFrom($this->store->getAggregateHistoryFor($this->basketId));

        // reconstituted baskets have no changes from the beginning
        $this->assertEquals(count($basket->getChanges()), 0);
    }
}