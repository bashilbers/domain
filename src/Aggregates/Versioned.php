<?php

namespace Domain\Aggregates;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
interface Versioned
{
    public function getVersion();
}
