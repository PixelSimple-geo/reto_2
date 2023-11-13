<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/driverManager.php";

$accountUrl = "/accounts";
$login = "/login";
$indexUrl = "/";

$path = $_SERVER['REQUEST_URI'];

if (stristr($path, $login)) {
    require_once "controller/mainController.php";
    login();
} else if (stristr($path, $indexUrl)) {

}
?>





