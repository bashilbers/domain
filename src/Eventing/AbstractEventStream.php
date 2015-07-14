<?php

namespace Domain\Eventing;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
abstract class AbstractEventStream implements \IteratorAggregate, \Countable
{
    protected $identity;

    protected $events;

    public function getIterator()
    {
        return new \ArrayIterator($this->events);
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function count()
    {
        return count($this->events);
    }

    public function first()
    {
        return array_shift(array_values($this->events));
    }

    public function last()
    {
        return array_pop(array_values($this->events));
    }

    public function getEvents()
    {
        return $this->events;
    }
}
