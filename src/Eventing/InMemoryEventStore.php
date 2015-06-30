<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
final class InMemoryEventStore implements EventStore
{
    private $events = [];

    public function commit(UncommittedEvents $stream)
    {
        $aggregateId = $stream->first()->getAggregateIdentity();

        foreach ($stream as $event) {
            $this->events[(string) $aggregateId][] = $event;
        }

        return new CommittedEvents($aggregateId, $stream->getEvents());
    }

    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null)
    {
        return new CommittedEvents(
            $id,
            array_filter(
                array_slice($this->events[(string)$id], $offset, $max, true),
                function (DomainEvent $event) use ($id) {
                    return $event->getAggregateIdentity()->equals($id);
                }
            )
        );
    }
}
