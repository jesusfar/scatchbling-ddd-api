<?php

namespace Scatchbling\Scratcher\Infrastructure\Persistence\pdo;


/**
 * Class PDORepository
 * @package Scatchbling\Scratcher\Infrastructure\Persistence\pdo
 */
abstract class PDORepository
{
    /**
     * @var
     */
    private $pdoConnection = null;



    private $config;

    /**
     * PDORepository constructor.
     * @param $connection
     */
    public function __construct(PDOConnection $connection)
    {
        $this->pdoConnection = $connection;
    }

    /**
     * @return mixed
     */
    public function getPdoConnection() : PDOConnection
    {
        return $this->pdoConnection;
    }

    /**
     * @param string $sql
     * @param $args
     * @return mixed
     */
    private function exec(string $sql, $args) {
        try {
            $connection = $this->getPdoConnection()->getConnection();
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
        return $this->exec($sql, $args);
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