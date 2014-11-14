<?php

namespace Domain\Events;

/**
 * Description of AbstractEventStream
 *
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
abstract class AbstractEventStream implements \IteratorAggregate, \Countable, \ArrayAccess
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

    public function getEvents()
    {
        return $this->events;
    }

    public function count()
    {
        return count($this->events);
    }

    public function offsetExists($offset)
    {
        return isset($this->events[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->events[$offset]) ? $this->events[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->events[] = $value;
        } else {
            $this->events[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->events[$offset]);
    }
}