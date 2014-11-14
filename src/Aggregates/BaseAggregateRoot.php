<?php

namespace Domain\Aggregates;

use Domain\Identity\Identity;
use Domain\Events\When\ConventionBasedWhen;

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

    public function __construct(Identity $id)
    {
        $this->identity = $id;
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