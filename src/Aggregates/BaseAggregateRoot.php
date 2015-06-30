<?php

namespace Domain\Aggregates;

use Domain\Identity\Identity;
use Domain\Eventing\When\ConventionBasedWhen;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
abstract class BaseAggregateRoot implements AggregateRoot
{
    use Reconstitution;
    use EventSourced;
    use ConventionBasedWhen;

    private $identity;

    private $version = 0;

    protected function __construct(Identity $id)
    {
        $this->identity = $id;
    }

    public static function fromIdentity(Identity $id)
    {
        return new static($id);
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function getVersion()
    {
        return $this->version;
    }
}
