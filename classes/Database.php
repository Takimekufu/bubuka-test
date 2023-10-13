<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/classes/Connection.php';

class DataBase {
    
    private static ?PDO $conn = null;

    private const TABLES = ['albums', 'tracks', 'genres', 'tags'];

    public static function createTables() : void {
        
        self::getConnection()->query("CREATE TABLE IF NOT EXISTS " . self::TABLES[0] . 
                           " (id MEDIUMINT UNSIGNED PRIMARY KEY, 
                            cover VARCHAR(1000) DEFAULT NULL, 
                            name VARCHAR(255) NOT NULL, 
                            description VARCHAR(5000) DEFAULT NULL, 
                            total_count SMALLINT UNSIGNED NOT NULL, 
                            total_duration TIME NOT NULL)");

        self::getConnection()->query("CREATE TABLE IF NOT EXISTS " . self::TABLES[1] . 
                           " (id INT UNSIGNED PRIMARY KEY, 
                            artist VARCHAR(255) DEFAULT NULL, 
                            name VARCHAR(255) NOT NULL, 
                            duration TIME NOT NULL, 
                            bpm SMALLINT UNSIGNED NOT NULL, 
                            file VARCHAR(1000) NOT NULL, 
                            album_id MEDIUMINT UNSIGNED NOT NULL,
                            marks JSON,
                            FOREIGN KEY (album_id) REFERENCES albums (id))");
        
        self::getConnection()->query("CREATE TABLE IF NOT EXISTS " . self::TABLES[2] . 
                           " (id SMALLINT UNSIGNED PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL)");

        self::getConnection()->query("CREATE TABLE IF NOT EXISTS " . self::TABLES[3] . 
                           " (id SMALLINT UNSIGNED PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL)");
    }

    public static function dropTables() : void {
        $tables = implode(", ", self::TABLES);
        self::getConnection()->query("DROP TABLE ". $tables);
    }

    protected static function getConnection() : PDO{
        if (self::$conn === null) {
            $root = $_SERVER['DOCUMENT_ROOT'];
            require_once $root . '/classes/Connection.php';
            self::$conn = Connection::start(); 
        }
        return self::$conn;
    }
    
    
    private function __construct() {}
    private function __clone() {}
}
