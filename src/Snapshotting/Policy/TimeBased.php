<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;
use Domain\Snapshotting\SnapshottingPolicy;
use Domain\Snapshotting\SnapshotStore;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class TimeBased implements SnapshottingPolicy
{
    private $threshold;

    public function __construct(SnapshotStore $store, $threshold = '1 hour')
    {
        $this->store = $store;
        $this->threshold = $threshold;
    }

    public function shouldCreateSnapshot(AggregateRoot $root)
    {
        if ($root->hasChanges()) {
            $lastSnapshot = $this->store->get($root->getIdentity());
            $threshold = new \DateTime(date('c', strtotime('-' . $this->threshold)));

            if ($lastSnapshot->getCreationDate() > $threshold) {
                return true;
            }
        }

        return false;
    }
}