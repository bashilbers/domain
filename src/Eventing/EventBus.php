<?php

namespace Domain\Events;

use Domain\Eventing\Exception\InvalidMiddlewareException;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class EventBus
{
    public function __construct(array $middleware)
    {
        $this->middlewareChain = $this->createExecutionChain($middleware);
    }

    public function publish(CommittedEvents $events)
    {

    }

    private function createExecutionChain(array $middlewareList)
    {
        $lastCallable = function ($command) {
            // the final callable is a no-op
        };

        while ($middleware = array_pop($middlewareList)) {
            if (! $middleware instanceof Middleware) {
                throw InvalidMiddlewareException::forMiddleware($middleware);
            }

            $lastCallable = function ($command) use ($middleware, $lastCallable) {
                return $middleware->execute($command, $lastCallable);
            };
        }

        return $lastCallable;
    }
}