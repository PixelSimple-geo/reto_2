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
} else if (matchURI("/history")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/mainController.php";
    if ($requestMethod === "GET") history();
} else if (matchURI("/contact")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/mainController.php";
    if ($requestMethod === "GET") contact();
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
        if ($requestMethod === "GET") getBusinessPage();
    } else if (matchURI("/businesses/all")) {
        if ($requestMethod === "GET") getBusinesses();
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
} else if (matchURI("/articles")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/articlesController.php";
    if (matchURI("/articles/article")) {
        if ($requestMethod === "GET") getArticleById();
    } else if (matchURI("/articles/all")) {
        if ($requestMethod === "GET") getArticles();
    } else if (matchURI("/articles/crud")) {
        if (matchURI("/articles/crud/all")) {
            if ($requestMethod === "GET") getArticlesCrudReadAll();
        } else if (matchURI("/articles/crud/add")) {
            if ($requestMethod === "GET") getArticlesCrudAdd();
            else if ($requestMethod === "POST") postArticlesCrudAdd();
        } else if (matchURI("/articles/crud/edit")) {
            if ($requestMethod === "GET") getArticlesCrudEdit();
            else if ($requestMethod === "POST") postArticlesCrudEdit();
        } else if (matchURI("/articles/crud/delete")) {
            if ($requestMethod === "GET") getArticlesCrudDelete();
        }
    }
} else if (matchURI("/reviews/crud")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/reviewsController.php";
    if (matchURI("/reviews/crud/add")) postReviewCrudAdd();
} else if (matchURI("/likes/crud")) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/reviewsController.php";
    if (matchURI("/likes/crud/add")) postReviewLikeCrudAdd();
} else if (matchURI("/products")){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/advertsController.php";
    getAdverts();
}


