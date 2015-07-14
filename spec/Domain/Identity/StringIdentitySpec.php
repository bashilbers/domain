<?php

namespace spec\Domain\Identity;

use Domain\Identity\StringIdentity;
use PhpSpec\ObjectBehavior;

class StringIdentitySpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Domain\Identity\DummyStringIdentity');
        $this->beConstructedWith('foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\Identity\StringIdentity');
    }

    function it_should_be_an_identity()
    {
        $this->shouldImplement('Domain\Identity\Identity');
    }

    function it_should_only_allow_string_input()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('__construct', [12345]);
    }

    function it_should_be_able_to_compare_equality()
    {
        $this->equals($this)->shouldBe(true);
        $this->equals(new DummyStringIdentity('bar'))->shouldBe(false);
    }
}

class DummyStringIdentity extends StringIdentity
{
}
