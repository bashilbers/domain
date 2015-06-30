<?php

namespace Domain\Eventing\Exception;

class InvalidMiddlewareException extends \InvalidArgumentException implements Exception
{
    public static function forMiddleware($middleware)
    {
        $name = is_object($middleware) ? get_class($middleware) : gettype($middleware);
        $message = sprintf(
            'Cannot add "%s" to middleware chain as it does not implement the Middleware interface.',
            $name
        );
        return new static($message);
    }
}
