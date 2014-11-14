<?php

namespace Domain\Commands\CommandBus;

/**
 * Process Commands and pass them to their handlers in sequential order.
 *
 * If commands are triggered within command handlers, this command bus puts
 * them on a stack and waits with the execution to allow sequential processing
 * and avoiding nested transactions.
 *
 * Any command handler execution can be wrapped by additional handlers to form
 * a chain of responsibility. To control this process you can pass an array of
 * proxy factories into the CommandBus. The factories are iterated in REVERSE
 * order and get passed the current handler to stack the chain of
 * responsibility. That means the proxy factory registered FIRST is the one
 * that wraps itself around the previous handlers LAST.
 */
class DefaultCommandBus implements CommandBus
{
    private $locator;

    private $stack = [];

    private $executing = false;

    public function __construct(HandlerLocator $locator = null)
    {
        if (is_null($locator))

        $this->locator = $locator;
    }

    /**
     * Sequentially execute commands
     *
     * If an exception occurs in any command it will be put on a stack
     * of exceptions that is thrown only when all the commands are processed.
     *
     * @param object $command
     * @throws CommandFailedStackException
     */
    public function handle($command)
    {
        $this->stack[] = $command;

        if ($this->executing) {
            throw new \Exception('Cant\'t handle commands while executing');
        }

        $first = true;

        while ($command = array_shift($this->stack)) {
            $this->execute($command, $first);
            $first = false;
        }
    }

    protected function execute($command, $first)
    {
        $this->executing = true;

        try {
            $handler = $this->locator->getHandlerFor($command);
            $method  = $this->getHandlerMethodName($command);

            if (!method_exists($handler, $method)) {
                throw new \RuntimeException("Handler " . get_class($handler) . " has no method " . $method . " to handle command.");
            }

            $service->$method($command);
        } catch (\Exception $ex) {
            $this->executing = false;

            if ($first) {
                throw $e;
            }
        }

        $this->executing = false;
    }

    protected function getHandlerMethodName($command)
    {
        $parts = explode("\\", get_class($command));

        return str_replace("Command", "", lcfirst(end($parts)));
    }
}

