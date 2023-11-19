<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

function matchURI($URI) :bool {
    return str_starts_with($_SERVER['REQUEST_URI'], $URI);
}

function validateRequiredParameters(array $parameters, $source = "POST"): void {
    $source = strtoupper($source);
    $requestData = ($source === "GET") ? $_GET : $_POST;
    foreach ($parameters as $parameter)
        if (empty($requestData[$parameter])) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_400.view.php";
            die();
        }
}

$requestMethod = $_SERVER["REQUEST_METHOD"];
startSession();
try {
    $userAccount = getUserAccountFromSession();
} catch (RuntimeException $exception) {
    $userAccount = null;
}

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
} else if (matchURI("/businesses")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    if (matchURI("/businesses/business")) {
        // For client
    } else if (matchURI("/businesses/all")) {
        // For client
    } else if (matchURI("/businesses/crud")) {
        if (matchURI("/businesses/crud/all")) {
            if ($requestMethod === "GET") getBusinessesCrudReadAll();
        } else if (matchURI("/businesses/crud/business")) {
            if ($requestMethod === "GET") getBusinessesCrudRead();
        } else if (matchURI("/businesses/crud/add")) {
            if ($requestMethod === "GET") getBusinessesCrudAdd();
            else if ($requestMethod === "POST") postBusinessesCrudAdd();
        } else if (matchURI("/businesses/crud/edit")) {
            if ($requestMethod === "GET") getBusinessesCrudEdit();
            else if ($requestMethod === "POST") postBusinessesCrudEdit();
        } else if (matchURI("/businesses/crud/delete")) {
            if ($requestMethod === "GET") getBusinessesCrudDelete();
        }
    }
} else if (matchURI("/adverts")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/advertsController.php";
    if (matchURI("/adverts/account/business/add")) {
        if ($requestMethod === "GET") getAddAdvertBusinessAccount();
        else if ($requestMethod === "POST") postAddAdvertBusinessAccount();
    } else if (matchURI("/adverts/account/business/edit")) {
      if ($requestMethod === "GET") getEditAdvertBusinessAccount();
      else if ($requestMethod === "POST");
    } else if (matchURI("/adverts/account/business")) {
        if ($requestMethod === "GET") getAdvertBusinessAccount();
    }
} else if (matchURI("/articleClient")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/articlesController.php";
    getArticles();
}else if (matchURI("/comerces")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    getCategories();
}else if (matchURI("/categories")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    getBusinessesByCategorie();
}else if (matchURI("/businessClient")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/businessesController.php";
    businessClient();
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





