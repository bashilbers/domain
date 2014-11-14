<?php

namespace Domain\Tests\Fixtures\Events;

use Domain\Tests\Fixtures\Identity\BasketId;
use Domain\Events\DomainEvent;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
final class BasketWasPickedUp implements DomainEvent
{
    private $basketId;

    public function __construct(BasketId $basketId)
    {
        $this->basketId = $basketId;
    }

    public function getAggregateIdentity()
    {
        return $this->basketId;
    }

    public function getVersion()
    {
        return 0;
    }

    public function getCreationDate()
    {
        return new \DateTime();
    }
}