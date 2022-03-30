<?php

namespace Logeecom\Bookstore\data_access;
use PDO;

class DatabaseConnection
{

    /**
     * @var DatabaseConnection|null - Singleton DatabaseConnection instance.
     */
    private static ?DatabaseConnection $connection = null;

    private PDO $PDOConnection;

    /**
     * Construct DatabaseConnection singleton.
     */
    private function __construct()
    {
        $config = include $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
        
        $this->PDOConnection = new PDO(
            $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['db_name'],
            $config['username'],
            $config['password']
        );
    }

    /**
     * @return DatabaseConnection - Singleton instance of DatabaseConnection.
     */
    public static function getInstance(): DatabaseConnection
    {
        if (DatabaseConnection::$connection == null) {
            DatabaseConnection::$connection = new DatabaseConnection();
        }

        return DatabaseConnection::$connection;
    }

    /**
     * @return PDO - PDO connection.
     */
    public function getPDOConnection(): PDO
    {
        return $this->PDOConnection;
    }

}