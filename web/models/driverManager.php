<?php

$hostName = "localhost";
$port = "3306";
$database = "reto_2";
$username = "admin";
$password = "admin";

function getConnection(): PDO {
    global $hostName, $port, $username, $password, $database;
    return new PDO("mysql:host=$hostName;port=$port;dbname=$database", $username, $password);
}
