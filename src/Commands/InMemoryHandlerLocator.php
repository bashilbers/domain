<?php

namespace Domain\Commands;

class InMemoryHandlerLocator implements HandlerLocator
{
    private $handlers = [];

    public function register($type, $handler)
    {
        if (!is_object($handler)) {
            throw new \RuntimeException("No valid handler given for command type '" . $type . "'");
        }

        $this->handlers[strtolower($type)] = $handler;

        return $this;
    }

    public function getHandlerFor(Command $command)
    {
        $type = get_class($command);

        if (!isset($this->handlers[strtolower($type)])) {
            throw new \RuntimeException("No service registered for command type '" . $type . "'");
        }

        return $this->handlers[strtolower($type)];
    }
}