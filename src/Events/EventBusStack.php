<?php

namespace Domain\Events;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class EventBusStack implements EventBus
{
    protected $busses;

    public function __construct(array $busses)
    {
        $this->busses = $busses;
    }

    public function publish(CommittedEvents $events)
    {
        foreach($this->busses as $bus) {
            $bus->publish($events);
        }
    }
}