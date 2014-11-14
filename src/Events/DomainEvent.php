<?php

namespace Domain\Events;

/**
 * Something that happened in the past, that is of importance to the business.
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface DomainEvent
{
    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateIdentity();

    public function getCreationDate();

    public function getVersion();
}