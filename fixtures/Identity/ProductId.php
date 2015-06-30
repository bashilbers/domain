<?php

namespace Domain\Fixtures\Identity;

use Domain\Identity\Identity;
use Domain\Identity\Generator;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class ProductId implements Identity, Generator
{
    private $productId;

    /**
     * @param string $productId
     */
    public function __construct($productId)
    {
        $this->productId = (string) $productId;
    }

    public static function fromString($string)
    {
        return new ProductId($string);
    }

    public function __toString()
    {
        return $this->productId;
    }

    public function equals(Identity $other)
    {
        return
            $other instanceof ProductId
            && (string) $this == (string) $other;
    }

    public static function generate()
    {
        $badSampleUuid = md5(uniqid());
        return new ProductId($badSampleUuid);
    }
}
