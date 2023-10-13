<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables rewrite</title>
</head>
<body>


<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/classes/Database.php';
require_once $root . '/classes/Controller.php';

DataBase::dropTables();
DataBase::createTables();
header("Location: index.php");
exit;
?>

</body>
</html>