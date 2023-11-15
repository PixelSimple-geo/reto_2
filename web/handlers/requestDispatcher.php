<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

startSession();

$path = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

$accountUrl = "/accounts";
$login = "/login";
$logout = "/logout";
$signIn = "/signIn";
$indexUrl = "/index";
$profileURI = "/profile";
$negociosUrl = "/negocios";
$_404_URI = "/error=404";
$_400_URI = "/error=400";
$crearNegocioUrl = "/crearNegocio";
$editarNegocioUrl = "/editarNegocio";
$articulosURL = "/articulos";
$crearArticuloURL = "/crearArticulo";
$editarArticuloUrl = "/editarArticulo";
$anunciosUrl = "/anuncios";


$path = $_SERVER['REQUEST_URI'];

if (stristr($path, $login)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/accountController.php";
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
} else if (stristr($path, $signIn)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/accountController.php";
    if ($requestMethod === "GET") getSignIn();
    else if ($requestMethod === "POST") {
        if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["email"])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
            die();
        }
        postSignIn();
    }
    die();
} else if (stristr($path, $indexUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    index();
    die();
} else if (stristr($path, $profileURI)){
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
}
//TODO hay que hacer los controladores para estos
else if (stristr($path, $negociosUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/negocios.view.php";
    die();
}else if (stristr($path, $crearNegocioUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/crearNegocio.view.php";
    die();
}else if (stristr($path, $editarNegocioUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/editarNegocio.view.php";
    die();
}else if (stristr($path, $articulosURL)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/articles.view.php";
    die();
}else if (stristr($path, $crearArticuloURL)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/crearArticulo.view.php";
    die();
}else if (stristr($path, $editarArticuloUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/editarArticulo.view.php";
    die();
}else if (stristr($path, $anunciosUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/views/anuncios.view.php";
    die();
}
?>





