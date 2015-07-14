<?php

namespace Domain\Aggregates;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface Versioned
{
    public function getVersion();
}
