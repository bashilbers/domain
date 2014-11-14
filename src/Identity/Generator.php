<?php

namespace Domain\Identity;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface Generator
{
    /**
     * @return Identity
     */
    public static function generate();
}