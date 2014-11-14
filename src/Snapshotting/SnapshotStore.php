<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;
use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
interface SnapshotStore
{
    public function get(Identity $id, $criteria = null);

    public function save(AggregateRoot $root);
}