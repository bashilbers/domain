<?php

namespace spec\Domain\Aggregates;

use Domain\Fixtures\Identity\BasketId;
use Domain\Fixtures\Identity\ProductId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseAggregateRootSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('Domain\Fixtures\Aggregates\Basket');
        $this->beConstructedThrough('pickup', [BasketId::generate()]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Aggregates\BaseAggregateRoot');
    }

    function it_should_have_an_identity()
    {
        $this->getIdentity()->beAnInstanceOf('Domain\Identity\Identity');
    }

    function it_should_record_changes()
    {
        //$this->recordThat()->shouldBeCalledTimes(1);

        $this->getChanges()->shouldHaveCount(1);
        $this->addProduct(ProductId::generate());
        $this->getChanges()->shouldHaveCount(2);
    }

    function it_should_be_able_to_discard_changes()
    {
        $this->getChanges()->shouldHaveCount(1);
        $this->addProduct(ProductId::generate());
        $this->getChanges()->shouldHaveCount(2);
        $this->clearChanges();
        $this->getChanges()->shouldHaveCount(0);
    }

    function it_should_be_able_to_tell_whether_it_has_changes()
    {
        $this->hasChanges()->shouldBe(true);
    }

    function it_should_only_allow_domainevents_to_be_recorded()
    {
        $this->shouldThrow()->during('recordThat', ['foo']);
    }

    function it_should_be_able_to_restore_to_a_previous_state_via_history()
    {

    }

    function it_should_know_the_current_version()
    {
        $this->getVersion()->shouldBe(1);
    }
}
