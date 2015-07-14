<?php

namespace Domain\Aggregates\Exception;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
final class AggregateRootNotFound extends \Exception
{
    private $aggregateRootIdentity;

    public function __construct($aggregateRootId)
    {
        $this->aggregateRootIdentity = $aggregateRootId;
    }

    public function getAggegateRootIdentity()
    {
        return $this->aggregateRootIdentity;
    }
}
