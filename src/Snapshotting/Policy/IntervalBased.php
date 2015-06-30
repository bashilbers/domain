<?php

namespace Domain\Snapshotting\Policy;

use Domain\Aggregates\AggregateRoot;
use Domain\Snapshotting\SnapshottingPolicy;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class IntervalBased implements SnapshottingPolicy
{
    private $interval;

    public function __construct($interval = 3)
    {
        $this->interval = $interval;
    }

    public function shouldCreateSnapshot(AggregateRoot $root)
    {
        if ($root->hasChanges()) {
            $lastEvent = $root->getChanges()[count($root->getChanges()) -1];
            $lastVersion = $lastEvent->getVersion();

            for ($i = $root->getVersion(); $i <= $lastVersion; $i++) {
                if ($i % $this->interval == 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
