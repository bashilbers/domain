<?php

namespace Domain\Aggregates;

use Domain\Identity\Identity;

/**
 * A collection oriented Repository for eventSourced Aggregates
 *
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface AggregateRepository
{
    /**
     * @param IdentifiesAggregate $aggregateId
     * @return IsEventSourced
     */
    public function get(Identity $aggregateId);

    /**
     * @param RecordsEvents $aggregate
     * @return void
     */
    public function save(RecordsEvents $aggregate);
}