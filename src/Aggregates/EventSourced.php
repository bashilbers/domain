<?php

namespace Domain\Aggregates;

use Domain\Eventing\DomainEvent;
use Domain\Eventing\UncommittedEvents;

/**
 * Sane default Behaviour and state for the RecordsEvents interface
 *
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
trait EventSourced
{
    /**
     * Collection of events that are not persisted yet
     * @var UncommittedEvents
     */
    private $uncommittedEvents;

    /**
     * Determine whether the object's state has changed since the last clearChanges();
     *
     * @return bool
     */
    public function hasChanges()
    {
        return !empty($this->uncommittedEvents);
    }

    /**
     * Get all changes to the object since the last the last clearChanges();
     *
     * @return UncommittedEvents
     */
    public function getChanges()
    {
        return $this->uncommittedEvents;
    }

    /**
     * Clear all state changes from this object.
     *
     * @return static
     */
    public function clearChanges()
    {
        $this->uncommittedEvents = new UncommittedEvents($this->getIdentity());

        return $this;
    }

    /**
     * Register a event happening on the aggregate
     *
     * @param DomainEvent $event
     * @return static
     */
    public function recordThat(DomainEvent $event)
    {
        $this->bumpVersion();

        if (is_null($this->uncommittedEvents)) {
            $this->uncommittedEvents = new UncommittedEvents($this->getIdentity());
        }

        $this->uncommittedEvents->append($event);
        $this->when($event);

        return $this;
    }

    abstract protected function bumpVersion();

    /**
     * The concrete class should have this method
     */
    abstract protected function when(DomainEvent $event);

    /**
     * The concrete class should have this method
     */
    abstract protected function getIdentity();
}
