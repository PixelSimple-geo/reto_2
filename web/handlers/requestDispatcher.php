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
    } else if (matchURI("/businesses/advertCategory")) {
        if(matchURI("/businesses/advertCategory/add")) postBusinessesAdvertCategoryCrudAdd();
        else if(matchURI("/businesses/advertCategory/delete")) deleteBusinessesAdvertCategoryCrudDelete();
    }
} else if (matchURI("/adverts")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/advertsController.php";
    if (matchURI("/adverts/advert")) {
        // For client
    } else if (matchURI("/adverts/all")) {

    } else if (matchURI("/adverts/crud")) {
        if (matchURI("/adverts/crud/add")) {
            if($requestMethod === "GET") getAdvertsCrudAdd();
            else if ($requestMethod === "POST") postAdvertsCrudAdd();
        } else if (matchURI("/adverts/crud/edit")) {
            if ($requestMethod === "GET") getAdvertsCrudEdit();
            else if ($requestMethod === "POST") postAdvertsCrudEdit();
        } else if (matchURI("/adverts/crud/delete")) {
            if ($requestMethod === "GET") getAdvertsCrudDelete();
        }
    }
} else if (matchURI("/articleNews")){
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
}else if (matchURI("/articleClient")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/articlesController.php";
    getArticleById();
}

