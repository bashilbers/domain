<?php

namespace Domain\Eventing;

use Predis\Client;
use Domain\Identity\Identity;
use Domain\Eventing\CommittedEvents;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
final class RedisEventStore implements EventStore
{
    private $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function commit(UncommittedEvents $events)
    {
        foreach ($events as $event) {
            $this->redis->rpush(
                (string) $event->getAggregateIdentity(),
                (string) serialize($event)
            );
        }
    }

    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null)
    {
        if (is_null($max)) {
            $max = $this->redis->llen((string) $id);
        }

        $events = $this->redis->lrange((string) $id, $offset, $max);

        return new CommittedEvents(
            $id,
            array_map(function ($raw) {
                return unserialize($raw);
            }, $events)
        );
    }
}
