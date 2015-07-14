<?php

namespace Domain\Aggregates;

use Domain\Eventing\CommittedEvents;
use Domain\Identity\Identity;

/**
 * Sane default behaviour and state for Reconstituable aggregates
 *
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
trait Reconstitution
{
    /**
     * Reconstructs given concrete aggregate and applies the history
     *
     * @param CommittedEvents $history
     * @return static
     */
    public static function reconstituteFrom(CommittedEvents $history)
    {
        $instance = static::fromIdentity($history->getIdentity());
        $instance->whenAll($history);

        return $instance;
    }

    /**
     * This trait requires a whenAll method on the concrete class
     *
     * @param $events
     */
    abstract protected function whenAll(CommittedEvents $events);

    /**
     * This trait requires a fromIdentity method on the concrete class
     *
     * @param Identity $identity
     * @return Aggregate
     */
    abstract public static function fromIdentity(Identity $identity);
}
