<?php

namespace Domain\Aggregates;

use Domain\Eventing\DomainEvent;
use Domain\Eventing\UncommittedEvents;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
trait EventSourced
{
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
    protected function recordThat(DomainEvent $event)
    {
        $this->bumpVersion();

        if (is_null($this->uncommittedEvents)) {
            $this->uncommittedEvents = new UncommittedEvents($this->getIdentity());
        }

        $this->uncommittedEvents->append($event);
        $this->when($event); // not sure

        return $this;
    }

    protected function bumpVersion()
    {
        $this->version++;
    }

    abstract protected function when(DomainEvent $event);

    abstract protected function getIdentity();
}
