<?php

namespace Scatchbling\Item\Infrastructure\persistence\pdo;


/**
 * Class PDORepository
 * @package Scatchbling\Item\Infrastructure\persistence\pdo
 */
abstract class PDORepository
{
    /**
     * @var
     */
    private $connection;

    /**
     * @return mixed
     */
    private function getConnection() {
        if (self::$connection == null) {
            // TODO get config from env variables.
            $db = "";
            $host = "";
            $user = "";
            $password = "";
            $this->connection = new \PDO("mysql:dbname$db;host=$host", $user, $password);
        } else {
            return $this->connection;
        }
    }

    /**
     * @param string $sql
     * @param $args
     * @return mixed
     */
    private function exec(string $sql, $args) {
        try {
            $connection = $this->getConnection();
            $stmt = $connection->prepare($sql);
            if (! $stmt->execute($args)) {
                // TODO throw repository exception
            }
            return $stmt;
        } catch (\PDOException $e) {
            // TODO throw repository exception
        }
    }

    /**
     * @param string $sql
     * @param $args
     * @return mixed
     */
    protected function execute(string $sql, $args) {
        $this->exec($sql, $args);
        return $stmt;
    }

    /**
     * @param string $sql
     * @param $args
     * @return mixed
     */
    protected function query(string $sql, $args) {
        $stmt = $this->exec($sql, $args);
        $rows = $stmt->fetchAll();
        return $rows;
    }
}