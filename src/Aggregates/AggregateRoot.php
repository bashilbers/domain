<?php

namespace Domain\Aggregates;

use Domain\Identity\Identity;

/**
 * Each concrete aggretegateRoot should implement default "aggregate" functionality
 *
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface AggregateRoot extends RecordsEvents, Reconstitutable, Versioned
{
    /**
     * @return Identity
     */
    public function getIdentity();

    /**
     * @param Identity $identity
     * @return AggregateRoot
     */
    public static function fromIdentity(Identity $identity);
}
