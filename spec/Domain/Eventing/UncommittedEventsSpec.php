<?php

namespace spec\Domain\Eventing;

use PhpSpec\ObjectBehavior;
use Domain\Fixtures\Identity\BasketId;
use Domain\Fixtures\Events\BasketWasPickedUp;

class UncommittedEventsSpec extends ObjectBehavior
{
    protected $basketId;

    function let()
    {
        $this->basketId = BasketId::generate();

        $this->beConstructedWith($this->basketId, []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Eventing\UncommittedEvents');
    }

    function it_should_be_able_to_append_events()
    {
        $event = new BasketWasPickedUp($this->basketId);

        $this->append($event);

        $this->last()->shouldBe($event);
    }

    function it_should_not_allow_appending_events_from_other_identities()
    {
        $event = new BasketWasPickedUp(BasketId::generate());

        $this->shouldThrow('Domain\Eventing\Exception\CorruptAggregateHistory')->during('append', [$event]);
    }
}
