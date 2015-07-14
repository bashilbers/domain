<?php

namespace Domain\Aggregates;

use Domain\Identity\Identity;
use Domain\Eventing\When\ConventionBasedWhen;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
abstract class BaseAggregateRoot implements AggregateRoot
{
    /**
     * Some functionality is coming from traits :)
     */
    use Reconstitution;
    use EventSourced;
    use ConventionBasedWhen;

    /**
     * @var Identity
     */
    private $identity;

    /**
     * @var int
     */
    private $version = 0;

    /**
     * @param Identity $id
     */
    protected function __construct(Identity $id)
    {
        $this->identity = $id;
    }

    /**
     * Gets the identity
     *
     * @param Identity $id
     * @return static
     */
    public static function fromIdentity(Identity $id)
    {
        return new static($id);
    }

    /**
     * Get the identity
     *
     * @return Identity
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Get aggregate version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
}
