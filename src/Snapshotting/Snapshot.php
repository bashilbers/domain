<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;
use Domain\Events\CommittedEvents;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class Snapshot
{
    private $version;

    private $aggregate;

    private $creationDate;

    public function __construct(AggregateRoot $aggregate, $version, $creationDate)
    {
        $this->aggregate = $aggregate;
        $this->version = $version;
        $this->creationDate = $creationDate;
    }

    /**
     * Get the aggregate root
     *
     * @return AggregateRoot
     */
    public function getAggregate()
    {
        return $this->aggregate;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getCreationDate()
    {
        return $this->creationDate();
    }

    /**
     * Apply missing events that were commited to the event store since this snapshot was made
     *
     * @param \Domain\Snapshotting\CommitedEvents $events
     */
    public function correctMissingHistory(CommittedEvents $events)
    {
        $this->aggregate->whenAll($events);

        return $this;
    }
}
