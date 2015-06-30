<?php

namespace Domain\Events;

use Domain\Events\Exception\CorrupHandlerStack;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class DirectEventBus implements EventBus
{
    protected $listeners = [];

    public function __construct(array $handlerMap = [])
    {
        foreach ($handlerMap as $eventName => $listener) {
            $this->subscribe($eventName, $listener);
        }
    }

    public function publish(CommittedEvents $events)
    {

    }

    public function subscribe($eventName, Listener $listener)
    {
        self::guardAgainstCorruptListener($listener);
    }

    protected static function guardAgainstInvalidListener($listener)
    {
        if (!$listener instanceof Listener) {
            throw new CorruptHandlerStack;
        }
    }
}