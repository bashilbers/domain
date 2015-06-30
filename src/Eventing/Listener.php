<?php

namespace Domain\Eventing;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
interface Listener
{
    public function handle(DomainEvent $event);
}
