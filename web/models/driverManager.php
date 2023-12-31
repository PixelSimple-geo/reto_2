<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

$hostName = "mysql";
$port = "3306";
$database = "reto_2";
$username = "admin";
$password = "admin";

function getConnection(): PDO {
    global $hostName, $port, $username, $password, $database;
    try {
        return new PDO("mysql:host=$hostName;port=$port;dbname=$database", $username, $password,
            [PDO::ATTR_PERSISTENT => true]);
    } catch (PDOException $exception) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_500_.view.php";
        die();
    }
}
