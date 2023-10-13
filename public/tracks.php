<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracks</title>
</head>
<body>

<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/classes/Controller.php';

$back = $_SERVER['HTTP_REFERER']; 
echo "<a href='{$back}'>Назад</a>";

$albumId = isset($_GET['albumid']) ? intval($_GET['albumid']) : 1;

echo "<table><tr><th>Id</th><th>Обложка</th><th>Название</th><th>Описание</th><th>Кол-во треков</th><th>Общая продолжительность</th></tr>";
$album = Controller::getAlbum($albumId);
    echo "<tr>";
        echo "<td>" . $album['id'] . "</td>";
        echo "<td>";
            echo "<img src=" . $album['cover'] . " alt=" . $album['name'] . " height=90 width=90 >";
        echo "</td>";
        echo "<td>" . $album['name'] . "</td>";
        echo "<td>" . $album['description'] . "</td>";
        echo "<td>" . $album['total_count'] . "</td>";
        echo "<td>" . $album['total_duration'] . "</td>";
    echo "</tr>";
echo "</table>";

echo "<hr>";

$tracks = Controller::getTracks($albumId);

echo "<table><tr><th>Id</th><th>Артист</th><th>Название</th><th>Продолжительность</th><th>BPM</th><th>Жанры</th><th>Теги</th><th>Ссылка</th></tr>";
foreach ($tracks as $track) {
    $marks = json_decode($track['marks'], true);
    echo "<tr>";
        echo "<td>" . $track['id'] . "</td>";
        echo "<td>" . $track['artist'] . "</td>";
        echo "<td>" . $track['name'] . "</td>";
        echo "<td>" . $track['duration'] . "</td>";
        echo "<td>" . $track['bpm'] . "</td>";
        echo "<td>";
        foreach ($marks['genres'] as $genre) {
            echo Controller::getGenre($genre) . " ";
        }
        echo "</td>";
        echo "<td>";
        foreach ($marks['tags'] as $tag) {
            echo Controller::getTag($tag) . " ";
        }
        echo "</td>";
        echo "<td>";
            echo  "<a href=\"" . $track['file'] . "\">" . $track['file'] . "</a>";
        echo "</td>";

    echo "</tr>";
}
echo "</table>";



?>

</body>
</html>