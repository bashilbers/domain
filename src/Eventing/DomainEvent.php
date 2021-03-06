<?php

namespace Domain\Eventing;

/**
 * Something that happened in the past, that is of importance to the business.
 *
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface DomainEvent extends \Serializable
{
    /**
     * @return Identity
     */
    public function getAggregateIdentity();

    public function getRecordedOn();

    public function getVersion();

    public function getSourceCodeRevision();
}
