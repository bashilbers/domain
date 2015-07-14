<?php

namespace Domain\Snapshotting;

use Symfony\Component\Finder\Finder;
use Domain\Identity\Identity;
use Domain\Aggregates\AggregateRoot;
use Domain\Snapshotting\Exception\IdenticalSnapshot;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
class FileSnapshotStore implements SnapshotStore
{
    private $dataPath;

    public function __construct($dataPath)
    {
        $this->dataPath = $dataPath;
    }

    public function get(Identity $id, $criteria = null)
    {
        $it = Finder::create()
            ->files()
            ->name((string) $id . '-*')
            ->in($this->dataPath);

        $files = iterator_to_array($it);

        if (empty($files)) {
            throw new \Exception;
        }

        $match = end($files);

        $time = $match->getMTime();
        $creation = new \DateTime;
        $creation->setTimestamp($time);

        $aggregate = unserialize(file_get_contents($match));

        $snapshot = new Snapshot(
            $aggregate,
            $aggregate->getVersion(),
            $creation
        );

        return $snapshot;
    }

    public function save(AggregateRoot $root)
    {
        $aggregateId = (string) $root->getIdentity();
        $versionFile = $aggregateId . '-' . $root->getVersion();

        if (file_exists($this->dataPath . '/' . $versionFile)) {
            throw new IdenticalSnapshot;
        }

        $stream = fopen($this->dataPath . '/' . $versionFile, 'w');

        fwrite($stream, serialize($root));
        fclose($stream);
    }
}
