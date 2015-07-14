<?php

namespace Domain\Snapshotting;

use Domain\Aggregates\AggregateRoot;

class CompositePolicy implements SnapshottingPolicy
{
    protected $policies = [];

    public function __construct(array $policies)
    {
        foreach ($policies as $policy) {
            if (!$policy instanceof SnapshottingPolicy) {
                throw new \InvalidArgumentException;
            }
        }

        $this->policies = $policies;
    }

    public function shouldCreateSnapshot(AggregateRoot $root)
    {
        foreach ($this->policies as $policy) {
            if (!$policy->shouldCreateSnapshot($root)) {
                return false;
            }
        }

        return true;
    }
}
