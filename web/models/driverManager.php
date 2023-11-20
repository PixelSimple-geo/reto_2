<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

$hostName = "mysql";
$port = "3306";
$database = "reto_2";
$username = "admin";
$password = "admin";

function getConnection(): PDO {
    global $hostName, $port, $username, $password, $database;
    return new PDO("mysql:host=$hostName;port=$port;dbname=$database", $username, $password, array(
        PDO::ATTR_PERSISTENT => true
    ));
}
