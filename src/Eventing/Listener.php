<?php

namespace Domain\Eventing;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface Listener
{
    public function handle(DomainEvent $event);
}
