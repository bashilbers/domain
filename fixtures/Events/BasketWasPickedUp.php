<?php

namespace Domain\Fixtures\Events;

use Domain\Fixtures\Identity\BasketId;
use Domain\Eventing\DomainEvent;

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

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    public function getRecordedOn()
    {
        // TODO: Implement getRecordedOn() method.
    }

    public function getSourceCodeRevision()
    {
        // TODO: Implement getSourceCodeRevision() method.
    }
}
