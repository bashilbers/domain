<?php

require __DIR__ . '/../vendor/autoload.php';

use Domain\Fixtures\Identity\BasketId;
use Domain\Fixtures\Identity\ProductId;
use Domain\Fixtures\Aggregates\Basket;
use Domain\Fixtures\Repository\BasketRepository;
use Domain\Eventing\InMemoryEventStore;

$basketId = BasketId::generate();
$basket = Basket::pickup($basketId);

$basket->addProduct(ProductId::generate());

// right now we already have registered an event on the aggregate called "basketWasPickedUp"

$eventStore = new InMemoryEventStore();
$repo = new BasketRepository($eventStore);

// the changes are saved into the store
$repo->save($basket);

// get the changes from the store and reconstitute the aggregatee
$reconstituted = $repo->get($basketId);
