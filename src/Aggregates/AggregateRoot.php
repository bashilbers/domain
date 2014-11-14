<?php

namespace Domain\Aggregates;

/*
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface AggregateRoot extends RecordsEvents, Reconstitutable, Versioned
{
    public function getIdentity();
}