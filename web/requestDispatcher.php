<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/driverManager.php";

$accountUrl = "/accounts";
$login = "/login";
$register = "/register";
$indexUrl = "/";

$path = $_SERVER['REQUEST_URI'];

if (stristr($path, $login)) {
    require_once "controller/mainController.php";
    login();
    die();
} else if (stristr($path, $register)) {
    require_once "controller/mainController.php";
    register();
    die();
}
?>





