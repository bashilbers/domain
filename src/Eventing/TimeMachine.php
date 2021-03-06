<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;
use Domain\Tools\ClassToString;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
class TimeMachine
{
    protected $store;

    protected $listeners = [];

    public function __construct(EventStore $store)
    {
        $this->store = $store;
    }

    public function attachListener($eventName, Listener $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function attachListeners(array $listeners)
    {
        foreach ($listeners as $event => $listener) {
            $this->attachListener($event, $listener);
        }

        return $this;
    }

    public function replayEvents(Identity $identity, $offset = null, $max = null)
    {
        $events = $this->store->getAggregateHistoryFor($identity, $offset, $max);

        foreach ($events as $event) {
            $method = 'when' . ClassToString::short($event);

            if (!isset($this->listeners[$method])) {
                continue;
            }

            if (is_array($this->listeners[$method])) {
                foreach ($this->listeners[$method] as $listener) {
                    call_user_func($listener, $event);
                }
            } else {
                call_user_func($this->listeners[$method], $event);
            }
        }

        return $this;
    }
}
