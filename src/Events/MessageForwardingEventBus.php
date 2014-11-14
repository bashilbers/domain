<?php

namespace Adchieve\Domain\Events;

/**
 * Description of BeanstalkEventBus
 *
 * @author Sebastiaan Hilbers <bas.hilbers@adchieve.com>
 */
class MessageForwardingEventBus implements EventBus
{
    protected $system;

    protected $fqcns = [];

    public function __construct(MessagingSystem $system, array $fqcns)
    {
        $this->system = $system;
        $this->fqcns = $fqcns;
    }

    public function publish(\Domain\Events\CommittedEvents $events)
    {
        foreach ($events as $event) {
            $handled = false;
            foreach ($this->fqcns as $fqcns) {
                if ($fqcns::handles($event)) {
                    $handled = true;
                }
            }
            if ($handled) {
                $this->system
                    ->getJobBuilder()
                    ->add($event)
                    ->in('domain-events');
            }
        }
    }
}