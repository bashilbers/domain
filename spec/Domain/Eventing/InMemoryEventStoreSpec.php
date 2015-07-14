<?php

namespace spec\Domain\Eventing;

use Domain\Eventing\UncommittedEvents;
use Domain\Fixtures\Identity\BasketId;
use Domain\Fixtures\Events\BasketWasPickedUp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryEventStoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Eventing\EventStore');
    }

    function it_should_add_events_in_memory()
    {
        $identity = BasketId::generate();
        $event = new BasketWasPickedUp($identity);

        $stream = new UncommittedEvents($identity);
        $stream->append($event);
        $this->commit($stream);

        $this->getAggregateHistoryFor($identity)->first()->shouldbe($event);
    }
}
