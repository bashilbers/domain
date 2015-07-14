<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
final class InMemoryEventStore implements EventStore
{
    /**
     * Events in memory
     * @var array
     */
    protected $events = [];

    /**
     * @param UncommittedEvents $stream
     * @return CommittedEvents
     */
    public function commit(UncommittedEvents $stream)
    {
        $aggregateId = $stream->first()->getAggregateIdentity();

        foreach ($stream as $event) {
            $this->events[(string) $aggregateId][] = $event;
        }

        return new CommittedEvents($aggregateId, $stream->getEvents());
    }

    /**
     * Gets the events stored as memory and wraps it in \CommittedEvents
     *
     * @param Identity $id
     * @param int $offset
     * @param null $max
     * @return CommittedEvents
     */
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
