<?php

namespace spec\Domain\Aggregates;

use Domain\Eventing\EventStore;
use Domain\Eventing\InMemoryEventStore;
use Domain\Fixtures\Aggregates\Basket;
use Domain\Fixtures\Identity\BasketId;
use Domain\Snapshotting\InMemorySnapshotStore;
use Domain\Snapshotting\SnapshotStore;
use Domain\Snapshotting\SnapshottingPolicy;
use PhpSpec\ObjectBehavior;

class BaseAggregateRepositorySpec extends ObjectBehavior
{
    function let(EventStore $store)
    {
        $this->beAnInstanceOf('Domain\Fixtures\Repository\BasketRepository');
        $this->beConstructedWith($store);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Aggregates\BaseAggregateRepository');
    }

    function it_should_persist_events_to_the_store(EventStore $store)
    {
        $this->beConstructedWith($store);

        $aggregate = Basket::pickup(BasketId::generate());
        $uncommitted = $aggregate->getChanges();
        $store->commit($uncommitted)->shouldBeCalled();

        // when
        $this->save($aggregate);
    }

    function it_should_be_able_to_create_snapshots(EventStore $store)
    {
        $snapshotStore = new InMemorySnapshotStore();
        $this->beConstructedWith($store, null, $snapshotStore);

        $basketId = BasketId::generate();
        $aggregate = Basket::pickup($basketId);

        $this->loadSnapshot($basketId)->shouldBe(null);
        $this->saveSnapshot($aggregate);
        $this->loadSnapshot($basketId)->shouldBeAnInstanceOf('Domain\Snapshotting\Snapshot');
    }

    function it_should_not_allow_getting_snapshots_when_no_store_was_attached(EventStore $store)
    {
        $this->beConstructedWith($store);

        $this->shouldThrow('\Exception')->duringLoadSnapshot(BasketId::generate());
    }

    function it_should_not_allow_saving_snapshots_when_no_store_was_attached(EventStore $store)
    {
        $this->beConstructedWith($store);

        $aggregate = Basket::pickup(BasketId::generate());

        $this->shouldThrow('\Exception')->duringSaveSnapshot($aggregate);
    }

    function it_should_ask_the_policy_if_snapshotting_is_required(EventStore $store, SnapshotStore $snapshotStore, SnapshottingPolicy $policy)
    {
        $this->beConstructedWith($store, null, $snapshotStore, $policy);

        $aggregate = Basket::pickup(BasketId::generate());

        $policy->shouldCreateSnapshot($aggregate)->shouldBeCalled();
        $this->save($aggregate);
    }

    function it_should_be_able_to_reconstitute_aggregates()
    {
        $store = new InMemoryEventStore();
        $this->beConstructedWith($store);

        $basketId = BasketId::generate();
        $aggregate = Basket::pickup($basketId);

        // when
        $this->save($aggregate);
        $this->get($basketId)->getIdentity()->shouldBe($basketId);
    }
}
