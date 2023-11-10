<?php

$hostName = "localhost";
$port = "3306";
$database = "reto_2";
$username = "admin";
$password = "admin";

function getConnection(){
    global $hostName, $port, $username, $password, $database;
    try {
    return new PDO("mysql:host=$hostName;dbname=$database", $username, $password);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
}
