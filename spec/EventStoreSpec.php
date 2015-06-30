<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventStoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('EventStore');
    }
}
