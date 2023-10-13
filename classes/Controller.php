<?php

set_time_limit(0);

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/classes/Connection.php';
require_once $root . '/models/Genre.php';
require_once $root . '/models/Tag.php';
require_once $root . '/models/Album.php';
require_once $root . '/models/Track.php';

Class Controller {

    private const RESOURCES = ['genres', 'tags', 'albums', 'albums/'];


    public static function addGenres() : bool {

        foreach (self::getApiData(self::RESOURCES[0]) as $data) {
            Genre::insert($data);
        }

        return true;
    }

    public static function addTags() : bool {

        foreach (self::getApiData(self::RESOURCES[1]) as $data) {
            Tag::insert($data);
        }

        return true;
    }

    public static function addAlbums() : bool {

        foreach (self::getApiData(self::RESOURCES[2]) as $data) {
            Album::insert($data);
        }

        return true;
    }

    public static function addTracks(int $limit = 10) : bool {

        $total_pages = self::getTotalAlbumPages($limit);
        for ($page = 0; $page < $total_pages; $page++) {
            foreach (Album::getIds($limit, $page) as $albumId) {
                foreach (self::getApiData(self::RESOURCES[3], albumId: $albumId) as $track) {
                    $track['album_id'] = $albumId;
                    Track::insert($track);
                }
            }
        }

        return true;
    }

    private static function getApiData(string $resource, int $limit = 10000, ?int $albumId = null) : Generator {
        
        $root = $_SERVER['DOCUMENT_ROOT'];
        $config = require $root . '/config.php';

        $currentPage = 0;

        $key = ($resource === self::RESOURCES[3]) ? 'tracks' : $resource;

        do {
            $params = [
                'limit' => $limit,
                'offset' => $limit * $currentPage,
            ];

            $url = $config['api']['base_url'] . '/' . $resource . $albumId . '?'. http_build_query($params);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'accept: application/json',
                'token: ' . $config['api']['token']
            ]);
            $data = json_decode(curl_exec($curl), true);
            curl_close($curl);

            $totalPages = $data['pagination']['total_pages'];
            $currentPage += 1;

            foreach ($data[$key] as $item) {
                yield $item;
            }

        } while ($currentPage < $totalPages);

    }

    public static function getTotalAlbumPages(int $limit) : int {
        return ceil(Album::getRecordsNum() / $limit);
    }

    public static function getAlbums(int $limit, int $page) : array {
        return Album::getAlbums($limit, $page - 1);
    }
    
    public static function getAlbum(int $albumId) : array {
        return Album::getAlbum($albumId);
    }

    public static function getTracks(int $albumId) : array {
        return Track::getTracks($albumId);
    }
    
    public static function getGenre(int $genre) : string {
        return Genre::getGenre($genre);
    }
    
    public static function getTag(int $tag) : string {
        return Tag::getTag($tag);
    }

    public static function tracksCheck() : bool {
        return (Track::getRecordsNum() !== 0) ? true : false;
    }

        
    private function __construct() {}
    private function __clone() {}

}