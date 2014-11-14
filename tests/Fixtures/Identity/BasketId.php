<?php

namespace Domain\Tests\Fixtures\Identity;

use Domain\Identity\Identity;
use Domain\Identity\Generator;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class BasketId implements Identity, Generator
{
    private $basketId;

    /**
     * @param string $basketId
     */
    public function __construct($basketId)
    {
        $this->basketId = (string) $basketId;
    }

    public static function fromString($string)
    {
        return new BasketId($string);
    }

    public function __toString()
    {
        return $this->basketId;
    }

    public function equals(Identity $other)
    {
        return
            $other instanceof BasketId
            && (string) $this == (string) $other;
    }

    public static function generate()
    {
        $badSampleUuid = md5(uniqid());
        return new BasketId($badSampleUuid);
    }
}