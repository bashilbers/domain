<?php

namespace Domain\Events;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
interface EventBus
{
    public function publish(CommittedEvents $events);
}