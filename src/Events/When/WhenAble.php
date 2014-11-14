<?php

namespace Domain\Events\When;

use Domain\Events\DomainEvent;

/**
 * Unfortunately we don't have method overloading in PHP. By implementing the `When` trait, you can simulate that by
 * delegating `when($myEvent)` to `whenMyEvent($myEvent)`. This prevents us from having to use conditionals to determine
 * how to react to an event.
 */
interface WhenAble
{
    /**
     * @param DomainEvent $event
     * @return void
     */
    abstract function when(DomainEvent $event);

    /**
     * @param \Traversable $events
     * @return void
     */
    abstract function whenAll($events);
}