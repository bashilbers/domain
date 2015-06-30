<?php

namespace Domain\Events;

interface Middleware
{
    /**
    * @param object   $command
    * @param callable $next
    *
    * @return mixed
    */
    public function execute(DomainEvent $event, callable $next);
}