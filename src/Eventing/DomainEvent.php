<?php

namespace Domain\Events;

/**
 * Something that happened in the past, that is of importance to the business.
 *
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface DomainEvent extends \Serializable
{
    public function getAggregateIdentity();

    public function getRecordedOn();

    public function getVersion();

    public function getSourceCodeRevision();
}