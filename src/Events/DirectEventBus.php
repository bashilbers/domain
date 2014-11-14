<?php

namespace Domain\Events;

use Domain\Events\Exception\CorrupHandlerStack;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class DirectEventBus implements EventBus
{
    protected $handlers;

    public function __construct(array $handlers)
    {
        foreach ($handlers as $handler) {
            if (!$handler instanceof Handler) {
                throw new CorruptHandlerStack;
            }
        }

        $this->handlers = $handlers;
    }

    public function publish(CommittedEvents $events)
    {
        foreach($events as $event) {
            foreach($this->handlers as $handler) {
                if ($handler::handles($event)) {
                    $handler->handle($event);
                }
            }
        }
    }
}