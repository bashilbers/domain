<?php

namespace Domain\Events;

use Domain\Identity\Identity;
use Domain\Events\CommittedEvents;

/**
 * @author Sebastiaan Hilbers <bas.hilbers@tribal-im.com.com>
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
     * @param \Domain\Events\UncommittedEvents $events
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
     * @return \Domain\Events\CommittedEvents
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

            //var_dump(fgets($stream)); echo PHP_EOL;

            $events[] = unserialize(fgets($stream));
            ++$i;
        }

        fclose($stream);

        return new CommittedEvents($id, $events);
    }
}