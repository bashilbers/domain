<?php

namespace Domain\Snapshotting;

use Domain\Identity\Identity;
use Domain\Aggregates\AggregateRoot;

/**
 * Class for testing snapshot generation.
 *
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
class InMemorySnapshotStore implements SnapshotStore
{
    /**
     * Snapshots by identity
     * @var array
     */
    private $snapshots = [];

    /**
     * Get the latest snapshot for given $id
     *
     * @param Identity $id
     * @param null $criteria
     * @return Snapshot
     */
    public function get(Identity $id, $criteria = null)
    {
        if (!array_key_exists((string) $id, $this->snapshots)) {
            return null;
        }

        return end($this->snapshots[(string) $id]);
    }

    /**
     * Save given snapshot
     *
     * @param AggregateRoot $root
     */
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
