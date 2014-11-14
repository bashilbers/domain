<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
interface SnapshottingPolicy
{
    public function shouldCreateSnapshot(AggregateRoot $root);
}