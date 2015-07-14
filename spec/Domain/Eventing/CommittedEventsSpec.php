<?php

namespace spec\Domain\Eventing;

use Domain\Fixtures\Events\BasketWasPickedUp;
use Domain\Fixtures\Events\ProductWasAdded;
use Domain\Fixtures\Identity\ProductId;
use PhpSpec\ObjectBehavior;
use Domain\Fixtures\Identity\BasketId;

class CommittedEventsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(BasketId::generate(), []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Eventing\AbstractEventStream');
    }

    function it_is_traverseable()
    {
        $this->shouldImplement('Traversable');
    }

    function it_is_countable()
    {
        $this->shouldImplement('Countable');
    }

    function it_should_only_allow_domain_events()
    {
        $this->shouldThrow('Domain\Eventing\Exception\CorruptAggregateHistory')->during('__construct', [BasketId::generate(), ['foo']]);
    }

    function it_should_be_able_to_find_the_first_and_last_event()
    {
        $basketId = BasketId::generate();
        $firstEvent = new BasketWasPickedUp($basketId);
        $secondEvent = new ProductWasAdded($basketId, ProductId::generate());

        $this->beConstructedWith($basketId, [$firstEvent, $secondEvent]);

        $this->first()->shouldBe($firstEvent);
        $this->last()->shouldBe($secondEvent);
    }
}
