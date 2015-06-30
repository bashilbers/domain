<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;
use Domain\Eventing\Exception\CorruptAggregateHistory;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class CommittedEvents extends AbstractEventStream
{
    private $fromVersion;

    private $toVersion;

    public function __construct(Identity $identity, array $events)
    {
        $this->identity = $identity;

        foreach ($events as $event) {
            if (!$event instanceof DomainEvent || !$event->getAggregateIdentity()->equals($identity)) {
                throw new CorruptAggregateHistory;
            }

            $this->events[] = $event;
        }

        if (count($events) > 0) {
            $this->fromVersion = array_shift(array_values($events));
            $this->toVersion = array_pop(array_values($events));
        }

        reset($this->events);
    }

    public function getFromVersion()
    {
        return $this->fromVersion;
    }

    public function getToVersion()
    {
        return $this->toVersion;
    }
}
