<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

$accountUrl = "/accounts";
$login = "/login";
$register = "/register";
$indexUrl = "/index";
$perfilUrl = "/perfil";
$negociosUrl = "/negocios";
$crearNegocioUrl = "/crearNegocio";
$editarNegocioUrl = "/editarNegocio";
$articulosURL = "/articulos";
$crearArticuloURL = "/crearArticulo";
$editarArticuloUrl = "/editarArticulo";
$anunciosUrl = "/anuncios";


$path = $_SERVER['REQUEST_URI'];

if (stristr($path, $login)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    login();
    die();
} else if (stristr($path, $register)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    register();
    die();
}else if (stristr($path, $indexUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/mainController.php";
    index();
    die();
}else if (stristr($path, $perfilUrl)){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controller/accountController.php";
    perfil();
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





