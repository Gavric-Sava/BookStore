<?php

namespace Logeecom\Bookstore\data_access;
use PDO;

class DatabaseConnection
{

    private static ?DatabaseConnection $connection = null;

    private PDO $PDOConnection;

    private function __construct()
    {
        $config = include $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
        
        $this->PDOConnection = new PDO(
            $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['db_name'],
            $config['username'],
            $config['password']
        );
    }

    public static function getInstance(): DatabaseConnection
    {
        if (DatabaseConnection::$connection == null) {
            DatabaseConnection::$connection = new DatabaseConnection();
        }
        return DatabaseConnection::$connection;
    }

    /**
     * @return PDO
     */
    public function getPDOConnection(): PDO
    {
        return $this->PDOConnection;
    }

}