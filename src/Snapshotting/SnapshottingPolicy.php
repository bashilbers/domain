<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
interface SnapshottingPolicy
{
    public function shouldCreateSnapshot(AggregateRoot $root);
}
