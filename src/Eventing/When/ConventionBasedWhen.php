<?php

namespace Domain\Eventing\When;

use Domain\Eventing\DomainEvent;
use Domain\Tools\ClassToString;
use Domain\Eventing\CommittedEvents;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
trait ConventionBasedWhen
{
    /**
     * Handle a single domain event
     *
     * @param DomainEvent $event
     * @return void
     */
    protected function when(DomainEvent $event)
    {
        $method = 'when' . ClassToString::short($event);
        if (is_callable([$this, $method])) {
            $this->{$method}($event);
        }
    }

    /**
     * Handle a committed event stream
     *
     * @param CommittedEvents $events
     * @return void
     */
    protected function whenAll(CommittedEvents $events)
    {
        foreach ($events as $event) {
            $this->when($event);
        }
    }
}
