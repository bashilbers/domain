<?php

namespace Domain\Events;

use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class NullEventStore implements EventStore
{
    public function commit(UncommittedEvents $events)
    {

    }

    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null)
    {

    }
}