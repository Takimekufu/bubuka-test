<?php

abstract Class Model {
    
    protected static ?PDO $conn = null;
    protected static string $tableName;

    protected static function getConnection() : PDO{
        if (self::$conn === null) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            require_once $root . '/classes/Connection.php';
            self::$conn = Connection::start(); 
        }
        return self::$conn;
    }
    
    public abstract static function insert(array $data);
    
    private function __construct() {}
    private function __clone() {}
}