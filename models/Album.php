<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/models/Model.php';

Class Album extends Model {

    protected static string $tableName = 'albums';

    public static function insert(array $album) : void {
        $stmt = parent::getConnection()->prepare("INSERT INTO " . self::$tableName .
                                      " (id, cover, name, description, total_count, total_duration) 
                                      VALUES (?,?,?,?,?,?)");
    
        $hours = isset($album['total_duration']['hours']) ? $album['total_duration']['hours'] : 0;
        $minutes = isset($album['total_duration']['minutes']) ? $album['total_duration']['minutes'] : 0;
        $seconds = isset($album['total_duration']['seconds']) ? $album['total_duration']['seconds'] : 0;

        $stmt->execute([
            $album['id'], 
            $album['cover'], 
            $album['name'], 
            $album['description'], 
            $album['total_count'], 
            "$hours:$minutes:$seconds"
        ]);

    }

    public static function getAlbum(int $albumId) : array {
        
        $stmt = parent::getConnection()->prepare("SELECT * FROM " . self::$tableName . " WHERE id = ?");
        $stmt->bindValue(1, $albumId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function getAlbums(int $limit = 10, int $page = 0) : array {

        $stmt = parent::getConnection()->prepare("SELECT * FROM " . self::$tableName . " LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit*$page, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRecordsNum() : int {

        $st = parent::getConnection()->query("SELECT COUNT(*) AS total_records FROM " . self::$tableName);
        $st = $st->fetchAll(PDO::FETCH_COLUMN);

        return $st[0];
    }

    public static function getIds(int $limit = 10, int $page = 0) : Generator {

        $stmt = parent::getConnection()->prepare("SELECT id FROM " . self::$tableName . " WHERE total_count > 0 LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit*$page, PDO::PARAM_INT);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $albumId) {

            yield $albumId;
        }
    }

}