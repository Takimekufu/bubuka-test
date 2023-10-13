<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/models/Model.php';

Class Tag extends Model {

    protected static string $tableName = 'tags';

    public static function insert(array $tag) : void {
        $stmt = self::getConnection()->prepare("INSERT INTO " . self::$tableName . " (id, name) VALUES (?,?)");

        $stmt->execute([$tag['id'], $tag['name']]);

    }

    public static function getTag(int $tagId) : string {
        $stmt = parent::getConnection()->prepare("SELECT name FROM " . self::$tableName . " WHERE id = ?");
        $stmt->bindValue(1, $tagId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

}