<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface EventStore
{
    /**
     * @param UncommittedEvents $events
     * @return CommittedEvents
     */
    public function commit(UncommittedEvents $events);

    /**
     * @param Identity $id
     * @return CommittedEvents
     */
    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null);
}
