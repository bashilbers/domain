<?php

namespace Domain\Aggregates;

use Domain\Identity\Identity;

/**
 * A collection oriented Repository for eventSourced Aggregates
 *
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface AggregateRepository
{
    /**
     * @param Identity $aggregateId
     * @return AggregateRoot
     */
    public function get(Identity $aggregateId);

    /**
     * @param AggregateRoot $aggregate
     * @return CommittedEvents
     */
    public function save(AggregateRoot $aggregate);
}
