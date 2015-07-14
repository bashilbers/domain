<?php

namespace Domain\Eventing;

use Domain\Identity\Identity;
use Domain\Tools\ClassToString;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
class MySqlEventStore implements EventStore
{
    /**
     * @var Connection
     */
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public static function createSchema(Connection $conn)
    {
        $sm = $conn->getSchemaManager();

        $schema = static::getSchema();
        foreach ($schema->getTables() as $table) {
            $sm->createTable($table);
        }
    }

    public static function getSchema()
    {
        $schema = new Schema();

        $streamTable = $schema->createTable('aggregate_events');

        $streamTable->addColumn('id', 'integer')
            ->setAutoincrement(true);
        $streamTable->addColumn('identity', 'string')
            ->setNotnull(true);
        $streamTable->addColumn('event', 'text')
            ->setNotnull(true);
        $streamTable->addColumn('data', 'text')
            ->setNotnull(true);
        $streamTable->setPrimaryKey(array('id'));

        return $schema;
    }

    public function commit(UncommittedEvents $events)
    {
        $query = '
            INSERT INTO `aggregate_events` (`identity`, `event`, `data`)
            VALUES (:identity, :event, :data)';

        $pdo = $this->conn->getWrappedConnection();

        foreach ($events as $event) {
            try {
                $pdo->beginTransaction();

                $stmt = $pdo->prepare($query);

                $stmt->execute([
                    ':identity' => (string) $event->getAggregateIdentity(),
                    ':event'    => (string) ClassToString::fqcn($event),
                    ':data'     => (string) serialize($event)
                ]);

                $pdo->commit();
            } catch (\PDOException $ex) {
                $pdo->rollBack();
                throw $ex;
            }
        }
    }

    public function getAggregateHistoryFor(Identity $id, $offset = 0, $max = null)
    {
        $query = "SELECT * FROM `aggregate_events` WHERE identity = :identity";

        if ($offset > 0) {
            $query .= " OFFSET {$offset}";
        }

        if (!is_null($max)) {
            $query .= " LIMIT {$max}";
        }

        $pdo = $this->conn->getWrappedConnection();

        $stmt = $pdo->prepare($query);
        $stmt->execute([':identity' => (string) $id]);

        return new CommittedEvents(
            $id,
            array_map(function ($row) {
                return unserialize($row['data']);
            }, $stmt->fetchAll(\PDO::FETCH_ASSOC))
        );
    }
}
