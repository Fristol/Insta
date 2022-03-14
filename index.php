<?php
session_start();
set_time_limit(180);
include 'config.php';
require_once 'db/create_datebase.php';
$createDB = new CreateDB;
$mysqli = new mysqli($servername, $username, $password);
if ($mysqli->query('show databases like insta') === TRUE) {
    echo "База данных уже создана";
} else {
    $createDB->createDatabase($servername, $username, $password);
    if ($mysqli->query('SHOW TABLES FROM insta LIKE currency') === TRUE) {
        echo "Таблица уже создана";
    } else {
        $createDB->createTable($servername, $username, $password, $dbname);
    }
}

