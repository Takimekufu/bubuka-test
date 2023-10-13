<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
</head>
<body>

<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/classes/Controller.php';

if (Controller::tracksCheck()) {
    header("Location: albums.php");
    exit;
} else {
    echo "<div>";
        echo 'База данных не заполнена -> ';
        echo  "<a href=\"db-rewrite.php\">";
            echo "ЗАПОЛНИТЬ";
        echo "</a>";
    echo "</div>"; 
    echo "<div>"; 
    echo "Не перезагружайте страницу, пока не увидите список альбомов!";
    echo "</div>";
    exit;
}

?>

</body>
</html>
