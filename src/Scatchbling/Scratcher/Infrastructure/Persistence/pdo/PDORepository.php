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
    private $connection = null;

    private $config;

    /**
     * PDORepository constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }


    /**
     * @return mixed
     */
    private function getConnection() {
        if ($this->connection == null) {
            $db = $this->config['dbname'];
            $host = $this->config['host'];
            $user = $this->config['user'];
            $password = $this->config['password'];

            try{
                $this->connection = new \PDO("mysql:host=$host;dbname=$db", $user, $password);
                return $this->connection;
            } catch (\PDOException $e) {
                // TODO handle error connection
                error_log('Error connection to databse: ' . $e->getMessage(), 3, '/tmp/scratcher.log');
            }
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