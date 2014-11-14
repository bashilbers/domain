<?php

namespace Domain\Tests\Fixtures\Aggregates;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Identity\ProductId;
use Domain\Tests\Fixtures\Events\BasketWasPickedUp;
use Domain\Tests\Fixtures\Events\ProductWasAdded;
use Domain\Aggregates\BaseAggregateRoot;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
final class Basket extends BaseAggregateRoot
{
    private $products = [];

    public static function pickup(BasketId $basketId)
    {
        $basket = new Basket($basketId);

        $basket->recordThat(
            new BasketWasPickedUp($basketId)
        );

        return $basket;
    }

    public function addProduct(ProductId $productId)
    {
        $this->recordThat(
            new ProductWasAdded($this->getIdentity(), $productId)
        );
    }

    public function getProductCount()
    {
        return count($this->products);
    }

    protected function whenBasketWasPickedUp(BasketWasPickedUp $event)
    {
        $this->products = [];
    }

    protected function whenProductWasAdded(ProductWasAdded $event)
    {
        $this->products[] = (string) $event->getProductId();
    }
}