<?php

namespace Domain\Events;

use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class UncommittedEvents extends AbstractEventStream
{
    public function __construct(Identity $identity)
    {
        $this->identity = $identity;
    }

    public function append(DomainEvent $event)
    {
        $this->events[] = $event;
    }
}