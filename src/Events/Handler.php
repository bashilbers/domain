<?php


namespace Domain\Events;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
interface Handler
{
    public static function handles(DomainEvent $event);

    public function handle(DomainEvent $event);
}