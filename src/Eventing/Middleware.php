<?php

namespace Domain\Eventing;

interface Middleware
{
    /**
    * @param DomainEvent   %event
    * @param callable $next
    *
    * @return mixed
    */
    public function execute(DomainEvent $event, callable $next);
}
