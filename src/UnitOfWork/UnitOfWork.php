<?php

namespace Domain\UnitOfWork;

use Domain\Events\EventStore;

/**
 * @TODO
 *
 * A Unit of Work will keep track of one or more Aggregates.
 * When the Unit of Work is committed, the changes will be persisted using a single commit for each Aggregate.
 * A UnitOfWork can also reconstitute an Aggregate from the Event Store.
 *
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class UnitOfWork
{
    protected $eventStore;

    protected $trackedAggregates = [];

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function track()
    {

    }

    public function commit()
    {
        foreach ($this->trackedAggregates as $aggregate) {
            if ($aggregate->hasChanges()) {
                $this->persistAggregate($aggregate);
            }
        }
    }

    public function get()
    {

    }

    protected function persistAggregate($aggregate)
    {

    }
}