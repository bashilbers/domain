<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class NoSnapshottingPolicy implements SnapshottingPolicy
{
    public function shouldCreateSnapshot(AggregateRoot $root)
    {
        return false;
    }
}
