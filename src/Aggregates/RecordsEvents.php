<?php

namespace Domain\Aggregates;

use Domain\Eventing\DomainEvent;

/**
 * Domain Eventing describe things that have happened, but where do they come from?
 * Wouldn’t it be nice if we could make the objects themselves responsible for recording
 * whatever happened to them? We can, by implementing the RecordsEvents interface.
 *
 * An object that records the events that happened to it since the last time it was cleared, or since it was
 * restored from persistence.
 *
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface RecordsEvents
{
    /**
     * Determine whether the object's state has changed since the last clearChanges();
     * @return bool
     */
    public function hasChanges();

    /**
     * Get all the Domain Eventing that were recorded since the last time it was cleared, or since it was
     * restored from persistence. This does not include events that were recorded prior.
     * @return UncommittedEvents
     */
    public function getChanges();

    /**
     * Clears the record of new Domain Eventing. This doesn't clear the history of the object.
     * @return void
     */
    public function clearChanges();

    /**
     * Register a event happening on the aggregate
     * @param DomainEvent $event
     */
    public function recordThat(DomainEvent $event);
}
