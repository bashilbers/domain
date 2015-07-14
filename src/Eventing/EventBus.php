<?php

namespace Domain\Eventing;

use Domain\Eventing\Exception\InvalidMiddlewareException;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@gmail.com>
 */
class EventBus
{
    public function __construct(array $middleware)
    {
        $this->middlewareChain = $this->createExecutionChain($middleware);
    }

    public function publish(CommittedEvents $events)
    {
        var_dump($events);
        exit;
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
