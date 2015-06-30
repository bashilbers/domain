<?php

namespace Domain\Events;

use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface EventStore
{
    /**
     * @param UncommittedEvents $events
     * @return void
     */
    public function commit(UncommittedEvents $events);

    /**
     * @param IdentifiesAggregate $id
     * @return CommittedEvents
     */
    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null);
}