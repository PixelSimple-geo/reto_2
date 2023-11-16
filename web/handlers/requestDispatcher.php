<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

function matchURI($URI) :bool {
    return str_starts_with($_SERVER['REQUEST_URI'], $URI);
}

startSession();

$path = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

$accountUrl = "/accounts";
$indexUrl = "/index";
$profileURI = "/profile";
$businessesURI = "/account/businesses";
$businessesAddURI = "/account/businesses/add";
$businessesEditURI = "/account/businesses/edit";
$_404_URI = "/error=404";
$_400_URI = "/error=400";
$crearNegocioUrl = "/crearNegocio";
$editarNegocioUrl = "/editarNegocio";
$articulosURL = "/articulos";
$crearArticuloURL = "/crearArticulo";
$editarArticuloUrl = "/editarArticulo";
$anunciosUrl = "/anuncios";

$path = $_SERVER['REQUEST_URI'];

if (matchURI("/login")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/accountController.php";
    switch ($requestMethod) {
        case "GET":
            getLogin();
            break;
        case "POST":
            postLogin();
            break;
    }
} else if (matchURI("/logout")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/mainController.php";
    logout();
} else if (matchURI("/signIn")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/accountController.php";
    switch ($requestMethod) {
        case "GET":
            getSignIn();
            break;
        case "POST":
            postSignIn();
            break;
    }
} else if (matchURI("/index")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/mainController.php";
    index();
} else if (matchURI("/account")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/accountController.php";
    switch ($requestMethod) {
        case "GET":
            getProfile();
            break;
        case "POST":
            postProfile();
            break;
        case "DELETE":
            deleteUserAccount();
            break;
    }
} else if (matchURI("/businesses/account/get")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    if ($requestMethod === "GET") getAccountBusinesses();
} else if (matchURI("/businesses/account/add")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    if ($requestMethod === "GET") getAddBusinesses();
    else if ($requestMethod === "POST") postBusiness();
    die();
} else if (matchURI("/businesses/account/edit")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    switch ($requestMethod) {
        case "GET":
            getEditBusiness();
            break;
        case "POST":
            postEditBusiness();
            break;
    }
} else if (matchURI("/businesses/account/delete")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    deleteAccountBusiness();
}
/*
//TODO hay que hacer los controladores para estos
else if (stristr($path, $crearNegocioUrl)){
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
*/





