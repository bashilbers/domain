<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
class NoSnapshottingPolicy implements SnapshottingPolicy
{
    public function shouldCreateSnapshot(AggregateRoot $root)
    {
        return false;
    }
}
