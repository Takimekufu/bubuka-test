<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albums</title>
</head>
<body>

<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/classes/Controller.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$limit = 10;
$total_pages = Controller::getTotalAlbumPages($limit);

$albums = Controller::getAlbums($limit, $page);

echo "Колличество альбомов на странице: " . count($albums);

echo "<table><tr><th>Id</th><th>Обложка</th><th>Название</th><th>Кол-во треков</th><th>Общая продолжительность</th></tr>";
foreach ($albums as $album) {
    echo "<tr>";
        echo "<td>" . $album['id'] . "</td>";
        echo "<td>";
            echo  "<a href=\"tracks.php?albumid=" . $album['id'] . "\">";
                echo "<img src=" . $album['cover'] . " alt=" . $album['name'] . " height=90 width=90 >";
            echo " </a>";
        echo "</td>";
        echo "<td>";
            echo  "<a href=\"tracks.php?albumid=" . $album['id'] . "\">" . $album['name'] . "</a>";
        echo "</td>";
        echo "<td>" . $album['total_count'] . "</td>";
        echo "<td>" . $album['total_duration'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<div>";
for ($page = 1 ; $page <= $total_pages; $page++) {
    echo "<a href=\"?page=" . $page . "\">" . $page . " </a>";
}
echo "</div>";

echo "<br>";

echo "<div>";
    echo  "<a href=\"tables-rewrite.php\">";
        echo "Удалить Базу Данных";
    echo "</a>";
echo "</div>";


?>

</body>
</html>









<?php
// $a = date('d.m.Y H:i:s'); 
// echo 'index ' . $a . '<br>';



//$contr->getAll();




// $a = date('d.m.Y H:i:s'); 
// $fd = fopen("log3.txt", 'a') or die("не удалось создать файл");
// fwrite($fd, " time: $a");
// fclose($fd);

// require_once 'classes/Database.php';
// require_once 'classes/Connection.php';


// require_once 'models/genre.php';

// $base_url = 'https://distributors.enter.yoga';
// $urn = '/genres';

// $token = 'uX281G3fueNboQvSisWUga2tyDck5QL8';

// $get = [
//     'limit' => '10',
//     'offset' => '0',
//     'ascending' => 'false'
// ];

// $headers =  [
//     'accept: application/json',
//     'token: ' . $token
// ];


// $curl = curl_init($base_url . $urn . '?'. http_build_query($get));
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// $data = json_decode(curl_exec($curl));
// curl_close($curl);

// genre::insert($data);

// foreach ($data->genres as $item) {

//     echo $item->name . '<br>';
// }

// foreach (Album::read() as $album) {
//     echo "{$album->id} {$album->name} {$album->total_count} {$album->total_duration}" . "<br>";
// }

// $st = Album::setTotalRecords();

// echo $st;



// $body = [
//     'email' => 'demo@demo.info',
//     'password' => 'demomc1229',
//     'token' => 'string',
//     'tz' => 'Asia/Tomsk'
// ];
// $data_string = json_encode($body, JSON_UNESCAPED_UNICODE);

// $curl = curl_init('https://distributors.enter.yoga/auth/login');
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// //curl_setopt($curl, CURLOPT_USERPWD, 'demo@demo.info:demomc1229');
// curl_setopt($curl, CURLOPT_HTTPHEADER, [
//     'Content-Type: application/json',
//     //'Content-Length: 86' /*. strlen($data_string)*/
// ]);

// //header('Content-Type: application/json; charset=utf-8');
// $data = json_decode(curl_exec($curl))->token;
// //$data = curl_exec($curl);
// curl_close($curl);
// echo $data;
