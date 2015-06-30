<?php

namespace Domain\Events;

/**
 * Description of AbstractEventStream
 *
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
}