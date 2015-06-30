<?php

namespace Domain\Aggregates;

use Domain\Identity\Identity;

/**
 * Interface AggregateRoot
 * @package Domain\Aggregates
 */
interface AggregateRoot extends RecordsEvents, Reconstitutable, Versioned
{
    /**
     * @return mixed
     */
    public function getIdentity();

    /**
     * @param Identity $identity
     * @return mixed
     */
    public static function fromIdentity(Identity $identity);
}
