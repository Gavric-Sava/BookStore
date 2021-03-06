<?php

namespace Logeecom\Bookstore\data_access;
use PDO;
use PDOException;

class DatabaseConnection
{

    private const CONNECTION_RETRY_PERIOD = 5000000;

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
        while (true) {
            try {
                $dsn = $_ENV['SQL_DRIVER'] . ':host=' . $_ENV['MYSQL_HOST'] . ';dbname=' . $_ENV['MYSQL_DATABASE'];
                $this->PDOConnection = new PDO(
                    $dsn,
                    $_ENV['MYSQL_USER'],
                    $_ENV['MYSQL_PASSWORD']
                );

                error_log("Connection success!");
                return;
            } catch (PDOException $e) {
                error_log("Connection failed, retrying...");
                error_log($e->errorInfo);
                error_log($e->getMessage());
                usleep(DatabaseConnection::CONNECTION_RETRY_PERIOD);
            }
        }
        

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