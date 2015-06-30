<?php

namespace Domain\Aggregates;

use Domain\Eventing\EventStore;
use Domain\Eventing\EventBus;
use Domain\Identity\Identity;
use Domain\Snapshotting\SnapshotStore;
use Domain\Snapshotting\SnapshottingPolicy;
use Domain\Snapshotting\Policy\IntervalBased;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
 */
abstract class BaseAggregateRepository implements AggregateRepository
{
    private $eventStore;

    private $eventBus;

    private $snapshotStore;

    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus = null,
        SnapshotStore $snapshotStore = null,
        SnapshottingPolicy $policy = null
    ) {
        $this->eventStore = $eventStore;
        $this->eventBus = $eventBus;
        $this->snapshotStore = $snapshotStore;

        // default policy sets up a 100 event interval for snapshotting
        if (!is_null($snapshotStore) && is_null($policy)) {
            $policy = new IntervalBased(100);
        }

        $this->snapshottingPolicy = $policy;
    }

    /**
     * To store the updates made to an Aggregate, we only need to
     * commit the latest recorded events to the EventStore.
     *
     * An eventbus can handle eventual or direct consistency.
     *
     * Snapsnots could be made if the policy allows it and this repo is
     * constructed with a storage for storing snapshots.
     */
    public function save(RecordsEvents $aggregate)
    {
        $uncommitted = $aggregate->getChanges();
        $committedStream = $this->eventStore->commit($uncommitted);

        // consider eventual consistency
        if (!is_null($this->eventBus)) {
            $this->eventBus->publish($committedStream);
        }

        // do we need to create a snapshot at this point?
        if (!is_null($this->snapshotStore) && $this->snapshottingPolicy->shouldCreateSnapshot($aggregate)) {
            $this->saveSnapshot($aggregate);
        }

        // remove changes on aggregate from memory
        $aggregate->clearChanges();

        return $committedStream;
    }

    /**
     * Fetching a single Aggregate is extremely easy: all we need to do is
     * reconstitute it from its history! Compare that to the complexity
     * of traditional ORMs.
     */
    public function get(Identity $aggregateId)
    {
        if (!is_null($this->snapshotStore)) {
            if (!($snapshot = $this->loadSnapshot($aggregateId))) {
                $missing = $this->eventStore->getAggregateHistoryFor($aggregateId, $snapshot->getVersion());

                if ($events) {
                    $snapshot->correctMissingHistory($missing);
                }

                return $snapshot->getAggregate();
            }
        }

        $aggregateHistory = $this->eventStore->getAggregateHistoryFor($aggregateId);
        $fqn = $this->getAggregateRootFqcn();

        return $fqn::reconstituteFrom($aggregateHistory);
    }

    abstract protected function getAggregateRootFqcn();

    /**
     * Load a aggregate snapshot from the storage
     *
     * @param \Domain\Identity\Identity $id
     * @return type
     */
    public function loadSnapshot(Identity $id)
    {
        return $this->snapshotStore->get($id);
    }

    /**
     * Save the aggregate state as single snapshot instead of multiple history events
     *
     * @param \Domain\Aggregates\AggregateRoot $aggregate
     * @return type
     * @throws \Exception
     */
    public function saveSnapshot(AggregateRoot $aggregate)
    {
        if (is_null($this->snapshotStore)) {
            throw new \Exception('Unable to create snapshot; No store attached');
        }

        if ($aggregate->hasChanges()) {
            $aggregate = $aggregate::reconstituteFrom(
                new \Domain\Eventing\CommittedEvents(
                    $aggregate->getIdentity(),
                    $aggregate->getChanges()
                )
            );
        }

        return $this->snapshotStore->save($aggregate);
    }
}
