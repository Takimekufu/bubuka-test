<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/models/Model.php';

Class Track extends Model {

    protected static string $tableName = 'tracks';

    public static function insert(array $track) {
        $stmt = self::getConnection()->prepare("INSERT INTO " . self::$tableName . 
                                      " (id, artist, name, duration, bpm, file, album_id, marks) 
                                      VALUES (?,?,?,?,?,?,?,?)");

        $hours = isset($track['duration']['hours']) ? $track['duration']['hours'] : 0;
        $minutes = isset($track['duration']['minutes']) ? $track['duration']['minutes'] : 0;
        $seconds = isset($track['duration']['seconds']) ? $track['duration']['seconds'] : 0;
        
        $duration = "$hours:$minutes:$seconds";

        $tagsIds = isset($track['tags']) ? implode(",", $track['genres'] ?? []) : null;
        $genresIds = isset($track['genres']) ? implode(",", $track['genres'] ?? []) : null;
        $marks = "{\"tags\" : [$tagsIds], \"genres\" : [$genresIds]}";
        
        try {
            $stmt->execute([
                $track['id'], 
                $track['artist'], 
                $track['name'], 
                $duration, 
                $track['bpm'],
                $track['file'],
                $track['album_id'],
                $marks
            ]); 
        } catch (PDOException $e) {
            //if ($e->getCode() != '23000') {
                //echo "mes:{$e->getMessage()} code:{$e->getCode()} <br>";
            //}
            $fd = fopen("log.txt", 'a');
            fwrite($fd, "mes:{$e->getMessage()} code:{$e->getCode()}\r\n");
            fclose($fd);
        };
    
    }
    
    public static function getTracks($albumId) : array {

        $stmt = parent::getConnection()->prepare("SELECT * FROM " . self::$tableName . " WHERE album_id = ?");
        $stmt->bindValue(1, $albumId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getRecordsNum() : int {

        $st = parent::getConnection()->query("SELECT COUNT(*) AS total_records FROM " . self::$tableName);
        $st = $st->fetchAll(PDO::FETCH_COLUMN);

        return $st[0];
    }
}