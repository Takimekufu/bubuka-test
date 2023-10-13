<?php

class Connection {

    private static ?PDO $conn = null;

    public static function start() : PDO {

        $root = $_SERVER['DOCUMENT_ROOT'];
        $params = require $root . '/config.php';

        if (self::$conn === null) {
            $dsn = 'mysql:host=' . $params['db']['host'] . ';charset=' . $params['db']['charset'];
            $conn = new PDO($dsn, $params['db']['user'], $params['db']['password']);
    
            $conn->query("CREATE DATABASE IF NOT EXISTS " . $params['db']['dbname'] . " CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
            
            $dsn = 'mysql:host=' . $params['db']['host'] . ';dbname=' . $params['db']['dbname'] . ';charset=' . $params['db']['charset'];
            self::$conn = new PDO($dsn, $params['db']['user'], $params['db']['password']);
        }
        
        return self::$conn;
    }

    private function __construct() {}
    private function __clone() {}

}
