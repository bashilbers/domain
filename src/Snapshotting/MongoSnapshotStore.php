<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;
use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
class MongoSnapshotStore implements SnapshotStore
{
    private $mongo;

    public function __construct(\MongoDb $mongo)
    {
        $this->mongo = $mongo;
    }

    public function get(Identity $id, $criteria = null)
    {
        $data = $this->mongo->aggregate_snapshots
            ->find(['identity' => (string) $id])
            ->sort(['creation_date' => -1])
            ->limit(1)
            ->getNext();

        $snapshot = new Snapshot(
            unserialize($data['aggregate']),
            $data['version'],
            $data['creation_date']
        );

        return $snapshot;
    }

    public function save(AggregateRoot $root)
    {
        return $this->mongo->aggregate_snapshots->insert([
            'identity'      => (string) $root->getIdentity(),
            'aggregate'     => serialize($root),
            'version'       => $root->getVersion(),
            'creation_date' => new \MongoDate
        ]);
    }
}
