<?php

namespace Scatchbling\Scratcher\Infrastructure\Persistence\pdo;


/**
 * Class PDOConnection
 * @package Scatchbling\Scratcher\Infrastructure\Persistence\pdo
 */
class PDOConnection
{
    /**
     * @var
     */
    private static $instance;
    /**
     * @var
     */
    private $connection;

    /**
     * PDOConnection constructor.
     */
    private  function __construct()
    {
    }

    /**
     * @return PDOConnection
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getConnection() : \PDO
    {
        return $this->connection;
    }

    /**
     * @param array $config
     */
    public function buildConnection(array $config)
    {
        $db = $config['dbname'];
        $host = $config['host'];
        $user = $config['user'];
        $password = $config['password'];

        try{
            $connection = new \PDO("mysql:host=$host;dbname=$db", $user, $password);
            $this->connection = $connection;
        } catch (\PDOException $e) {
            // TODO handle error connection
            error_log('Error connection to database: ' . $e->getMessage(), 3, '/tmp/scratcher.log');
        }
    }
}