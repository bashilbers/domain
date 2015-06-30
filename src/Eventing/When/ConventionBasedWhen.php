<?php

namespace Domain\Eventing\When;

use Domain\Eventing\DomainEvent;
use Domain\Tools\ClassToString;

/**
 * Description of ConventionBasedWhen
 *
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
trait ConventionBasedWhen
{
    /**
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
     * @param \Traverseable $events
     * @return void
     */
    protected function whenAll($events)
    {
        foreach ($events as $event) {
            $this->when($event);
        }
    }
}
