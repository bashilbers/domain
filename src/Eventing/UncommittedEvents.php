<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;
use Domain\Eventing\Exception\CorruptAggregateHistory;

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
        if ($event->getAggregateIdentity() !== $this->identity) {
            throw new CorruptAggregateHistory('Event Identity is not matching the eventstreams\'s identity');
        }

        $this->events[] = $event;
    }
}
