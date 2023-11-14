<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

$accountUrl = "/accounts";
$login = "/login";
$register = "/register";
$indexUrl = "/";

$path = $_SERVER['REQUEST_URI'];

if (stristr($path, $login)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    login();
    die();
} else if (stristr($path, $register)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    register();
    die();
}
?>





