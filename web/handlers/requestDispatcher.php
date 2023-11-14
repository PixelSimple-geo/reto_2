<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

startSession();

$path = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

$accountUrl = "/accounts";
$login = "/login";
$logout = "/logout";
$register = "/register";
$indexUrl = "/index";
$profileURI = "/profile";
$negociosUrl = "/negocios";
$_404_URI = "/error=404";
$_400_URI = "/error=400";

if (stristr($path, $login)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    if ($requestMethod === "GET") getLogin();
    else if ($requestMethod === "POST") {
        if (!isset($_POST["username"]) || !isset($_POST["password"])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
            die();
        }
        postLogin();
    }
    die();
} else if (stristr($path, $logout)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    logout();
    die();
} else if (stristr($path, $register)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    register();
    die();
}else if (stristr($path, $indexUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    index();
    die();
}else if (stristr($path, $profileURI)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/accountController.php";
    if ($requestMethod === "GET") getProfile();
    else if ($requestMethod === "POST") {
        if (!isset($_POST["password"])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
            die();
        }
        postProfile();
    }
    die();
}else if (stristr($path, $negociosUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/negocios.view.php";
    die();
}

