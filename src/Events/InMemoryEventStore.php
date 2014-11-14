<?php

namespace Domain\Events;

use Domain\Identity\Identity;
use Domain\Events\CommittedEvents;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
final class InMemoryEventStore implements EventStore
{
    private $events = [];

    public function commit(UncommittedEvents $events)
    {
        $aggregateId = (string) $events[0]->getAggregateIdentity();

        foreach ($events as $event) {
            $this->events[$aggregateId][] = $event;
        }
    }

    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null)
    {
        return new CommittedEvents(
            $id,
            array_filter(
                array_slice($this->events[(string) $id], $offset, $max, true),
                function (DomainEvent $event) use ($id) { return $event->getAggregateIdentity()->equals($id); }
            )
        );
    }
}