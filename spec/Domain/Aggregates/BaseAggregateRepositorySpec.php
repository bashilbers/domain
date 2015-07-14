<?php

namespace spec\Domain\Aggregates;

use Domain\Eventing\EventStore;
use Domain\Fixtures\Identity\BasketId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function it_should_persist_events_through_the_event_bus()
    {

    }

    function it_should_persist_snapshots_if_needed()
    {

    }

    function it_should_be_able_to_reconstruct_aggregates()
    {

    }
}
