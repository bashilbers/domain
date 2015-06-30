<?php

namespace Domain\Tests\Fixtures\Events;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Tests\Fixtures\Identity\ProductId;
use Domain\Eventing\DomainEvent;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
final class ProductWasAdded implements DomainEvent
{
    private $basketId;
    private $productId;

    public function __construct(BasketId $basketId, ProductId $productId)
    {
        $this->basketId = $basketId;
        $this->productId = $productId;
    }

    public function getAggregateIdentity()
    {
        return $this->basketId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getCreationDate()
    {
        return new \DateTime;
    }

    public function getVersion()
    {
        return 3333;
    }
}