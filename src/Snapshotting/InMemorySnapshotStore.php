<?php

namespace Domain\Snapshotting;

use Domain\Identity\Identity;
use Domain\Aggregates\AggregateRoot;

class InMemorySnapshotStore implements SnapshotStore
{
    private $snapshots = [];

    public function get(Identity $id, $criteria = null)
    {
        return end($this->snapshots[(string) $id]);
    }

    public function save(AggregateRoot $root)
    {
        $snapshot = new Snapshot(
            $root,
            $root->getVersion(),
            new \DateTime
        );

        $this->snapshots[(string) $root->getIdentity()][] = $snapshot;
    }
}