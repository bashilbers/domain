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
     * @return IsEventSourced
     */
    public function get(Identity $aggregateId);

    /**
     * @param RecordsEvents $aggregate
     * @return void
     */
    public function save(RecordsEvents $aggregate);
}
