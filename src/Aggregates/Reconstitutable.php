<?php

namespace Domain\Aggregates;

use Domain\Eventing\CommittedEvents;

/**
 * Loading our Aggregate back in history, simply involves reconstituting it
 * from all the events that it has recorded previously.
 * This concept is called Event Sourcing.
 * The events are the single source of elements that make up the Aggregate.
 *
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface Reconstitutable
{
    /**
     * @param CommittedEvents $history
     * @return AggregateRoot
     */
    public static function reconstituteFrom(CommittedEvents $history);
}
