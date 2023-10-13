<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/models/Model.php';

Class Genre extends Model {

    protected static string $tableName = 'genres';

    public static function insert(array $genre) : void {
        $stmt = self::getConnection()->prepare("INSERT INTO " . self::$tableName . " (id, name) VALUES (?,?)");

    $stmt->execute([$genre['id'], $genre['name']]);

    }
    
    public static function getGenre(int $genreId) : string {
        $stmt = parent::getConnection()->prepare("SELECT name FROM " . self::$tableName . " WHERE id = ?");
        $stmt->bindValue(1, $genreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

}