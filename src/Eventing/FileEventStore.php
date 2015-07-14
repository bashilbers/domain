<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
final class FileEventStore implements EventStore
{

    private $dataPath;

    public function __construct($dataPath)
    {
        $this->dataPath = $dataPath;
    }

    /**
     * Serialize given events and save them do disk.
     * Actually, each event is a new line inside a single file for each aggregate
     *
     * @param \Domain\Eventing\UncommittedEvents $events
     * @return void
     */
    public function commit(UncommittedEvents $events)
    {
        $aggregateId = (string) $events[0]->getAggregateIdentity();
        $stream = fopen($this->dataPath . '/' . $aggregateId, 'a');

        $i = 0;
        foreach ($events as $event) {
            $content = ($i > 0) ? PHP_EOL : '';
            $content .= serialize($event);
            fwrite($stream, $content);
            $i++;
        }

        fclose($stream);
    }

    /**
     * Open the aggregate file and read lines from $min to $max, unserialize and return
     * immutable event stream as "committed events".
     *
     * @param \Domain\Identity\Identity $id
     * @param integer $offset
     * @param integer $max
     * @return \Domain\Eventing\CommittedEvents
     */
    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null)
    {
        $stream = fopen($this->dataPath . '/' . (string) $id, 'r');

        $events = [];

        $i = 0;

        while (!feof($stream)) {
            if (!is_null($max) && $i > $max) {
                break;
            }

            if ($i < $offset) {
                continue;
            }

            $events[] = unserialize(fgets($stream));
            ++$i;
        }

        fclose($stream);

        return new CommittedEvents($id, $events);
    }
}
