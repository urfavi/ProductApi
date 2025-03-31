<?php

class Database {
    private static $instance = null;
    private $databaseConnection;
    private $host;
    private $databaseName;
    private $userName;
    private $password;

    public function __construct() {
        $this->host = "localhost";
        $this->databaseName = "store";
        $this->userName = "root";
        $this->password = "";

        try {
            $this->databaseConnection = new PDO(
                "mysql:host={$this->host};dbname={$this->databaseName}",
                $this->userName,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $this->databaseConnection->exec("set names utf8");
        } catch (PDOException $exception) {
            error_log("Database Connection Error: " . $exception->getMessage());
            die("Database connection failed. Contact administrator.");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->databaseConnection;
    }
}