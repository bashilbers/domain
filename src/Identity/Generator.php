<?php

namespace Domain\Identity;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface Generator
{
    /**
     * @return Identity
     */
    public static function generate();
}
