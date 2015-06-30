<?php

namespace Domain\Events;

use Domain\Identity\Identity;
use Domain\Events\Exception\CorruptAggregateHistory;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class CommittedEvents extends AbstractEventStream
{
    private $fromVersion;

    private $toVersion;

    public function __construct(Identity $identity, array $events = [])
    {
        $this->identity = $identity;

        foreach ($events as $event) {
            if (!$event instanceof DomainEvent) {
                throw new \InvalidArgumentException("DomainEvent expected");
            }

            if(!$event->getAggregateIdentity()->equals($identity)) {
                throw new CorruptAggregateHistory;
            }

            $this->events[] = $event;
        }

        $this->fromVersion = reset($this->events)->getVersion();
        $this->toVersion = end($this->events)->getVersion();

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