<?php

use JetBrains\PhpStorm\NoReturn;

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

#[NoReturn] function error_400_BadRequest(): void {
    http_response_code(400);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_400_.view.php";
    die();
}

#[NoReturn] function error_401_Unauthorized(): void {
    http_response_code(401);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_401_.view.php";
    die();
}

#[NoReturn] function error_403_Forbidden(): void {
    http_response_code(403);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_403_.view.php";
    die();
}

#[NoReturn] function error_404_NotFound(): void {
    http_response_code(404);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_404_.view.php";
    die();
}

#[NoReturn] function error_405_MethodNotAllowed(): void {
    http_response_code(405);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_405_.view.php";
    die();
}

#[NoReturn] function error_500_InternalServerError(): void {
    http_response_code(500);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_500_.view.php";
    die();
}

function validateRequiredParameters(array $parameters, $source = "POST"): void {
    $source = strtoupper($source);
    $requestData = ($source === "GET") ? $_GET : $_POST;
    foreach ($parameters as $parameter) if (empty($requestData[$parameter])) error_400_BadRequest();
}

startSession();
$userAccount = getUserAccountFromSession();

$url = $_SERVER["REQUEST_URI"];
$parsedUrl = parse_url($url);
$requestedRoute = explode("/", $parsedUrl["path"]);
array_shift($requestedRoute);

$routeMapping = [
    "login" => [
        "controller" => "accountController",
        "methods" => [
            "GET" => "getLogin",
            "POST" => "postLogin"
        ]
    ],
    "logout" => [
        "controller" => "accountController",
        "methods" => ["GET" => "logout"]
    ],
    "signIn" => [
        "controller" => "accountController",
        "methods" => [
            "GET" => "getSignIn",
            "POST" => "postSignIn"
        ]
    ],
    "history" => [
        "controller" => "mainController",
        "methods" => ["GET" => "history"]
    ],
    "contact" => [
        "controller" => "mainController",
        "methods" => [
            "GET" => "contact",
            "POST" => "postContact"
        ]
    ],
    "index" => [
        "controller" => "mainController",
        "methods" => ["GET" => "index"]
    ],
    "account" => [
        "controller" => "accountController",
        "security" => ["authentication" => "authenticate"],
        "methods" => [
            "GET" => "getProfile",
            "POST" => "postProfile",
            "DELETE" => "deleteUserAccount"
        ]
    ],
    "businesses" => [
        "controller" => "businessesController",
        "business" => [
            "methods" => ["GET" => "getBusinessPage"]
        ],
        "all" => [
            "methods" => ["GET" => "getBusinesses"]
        ],
        "crud" => [
            "security" => ["authentication" => "authenticate"],
            "all" => [
                "methods" => ["GET" => "getBusinessesCrudReadAll"]
            ],
            "business" => [
                "methods" => ["GET" => "getBusinessesCrudRead"]
            ],
            "add" => [
                "methods" => [
                    "GET" => "getBusinessesCrudAdd",
                    "POST" => "postBusinessesCrudAdd"
                ]
            ],
            "edit" => [
                "methods" => [
                    "GET" => "getBusinessesCrudEdit",
                    "POST" => "postBusinessesCrudEdit"
                ]
            ],
            "delete" => [
                "methods" => ["GET" => "getBusinessesCrudDelete"]
            ]
        ],
        "advertCategory" => [
            "security" => ["authentication" => "authenticate"],
            "add" => [
                "methods" => ["POST" => "postBusinessesAdvertCategoryCrudAdd"]
            ],
            "delete" => [
                "methods" => ["GET" => "deleteBusinessesAdvertCategoryCrudDelete"]
            ]
        ]
    ],
    "adverts" => [
        "controller" => "advertsController",
        "advert" => [
            "methods" => ["GET" => "getAdvertPage"]
        ],
        "all" => [],
        "crud" => [
            "security" => ["authentication" => "authenticate"],
            "add" => [
                "methods" => [
                    "GET" => "getAdvertsCrudAdd",
                    "POST" => "postAdvertsCrudAdd"
                ]
            ],
            "edit" => [
                "methods" => [
                    "GET" => "getAdvertsCrudEdit",
                    "POST" => "postAdvertsCrudEdit"
                ]
            ],
            "delete" => [
                "methods" => ["GET" => "getAdvertsCrudDelete"]
            ]
        ]
    ],
    "articles" => [
        "controller" => "articlesController",
        "article" => [
            "methods" => ["GET" => "getArticleById"]
        ],
        "all" => [
            "methods" => ["GET" => "getArticles"]
        ],
        "crud" => [
            "security" => [
                "authentication" => "authenticate",
                "authorization" => [
                    "method" => "authorize",
                    "role" => "PUBLISHER"
                ]
            ],
            "all" => [
                "methods" => ["GET" => "getArticlesCrudReadAll"]
            ],
            "add" => [
                "methods" => [
                    "GET" => "getArticlesCrudAdd",
                    "POST" => "postArticlesCrudAdd"
                ]
            ],
            "edit" => [
                "methods" => [
                    "GET" => "getArticlesCrudEdit",
                    "POST" => "postArticlesCrudEdit"
                ]
            ],
            "delete" => [
                "methods" => ["GET" => "getArticlesCrudDelete"]
            ]
        ]
    ],
    "reviews" => [
        "controller" => "reviewsController",
        "crud" => [
            "security" => ["authentication" => "authenticate"],
            "add" => [
                "methods" => ["POST" => "postReviewCrudAdd"]
            ]
        ]
    ],
    "reviewsLikes" => [
        "controller" => "reviewsController",
        "crud" => [
            "security" => ["authentication" => "authenticate"],
            "methods" => ["POST" => "postReviewLikeCrudAddEditDelete"]
        ]
    ],
    "products" => [
        "controller" => "advertsController",
        "methods" => ["GET" => "getAdverts"]
    ],
    "commentaries" => [
        "controller" => "commentariesController",
        "crud" => [
            "security" => ["authentication" => "authenticate"],
            "add" => [
                "methods" => ["POST" => "postCommentaryCrudAdd"]
            ]
        ]
    ],
    "commentariesLikes" => [
        "controller" => "commentariesController",
        "crud" => [
            "security" => ["authentication" => "authenticate"],
            "methods" => ["POST" => "postCommentaryLikeCrudAddEditDelete"]
        ]
    ],
    "cookiePolicy" => [
        "controller" => "mainController",
        "methods" => ["GET" => "showCookiePolicy"]
    ],
    "admin" => [
        "security" => [
            "authentication" => "authenticate",
            "authorization" => [
                "method" => "authorize",
                "role" => "ADMIN"
            ]
        ],
        "accounts" => [
            "controller" => "adminControllers/accounts",
            "read" => ["methods" => ["GET" => "adminReadAccounts"]],
            "updateAuthorities" => ["methods" => ["POST" => "adminUpdateAccountAuthorities"]],
            "delete" => ["methods" => ["GET" => "adminDeleteAccount"]]
        ],
        "adverts" => [
            "controller" => "adminControllers/adverts",
            "read" => ["methods" => ["GET" => "adminReadAdverts"]],
            "delete" => ["methods" => ["GET" => "adminDeleteAdvert"]]
        ],
        "articles" => [
            "controller" => "adminControllers/articles",
            "read" => ["methods" => ["GET" => "adminReadArticles"]],
            "delete" => ["methods" => ["GET" => "adminDeleteArticle"]]
        ],
        "articlesCategories" => [
            "controller" => "adminControllers/articleCategories",
            "read" => ["methods" => ["GET" => "adminReadArticlesCategories"]],
            "add" => ["methods" => ["POST" => "adminAddArticlesCategories"]],
            "delete" => ["methods" => ["GET" => "adminDeleteArticleCategory"]]
        ],
        "reviews" => [
            "controller" => "adminControllers/reviews",
            "read" => ["methods" => ["GET" => "adminReadReviews"]],
            "delete" => ["methods" => ["GET" => "adminDeleteReview"]]
        ],
        "commentaries" => [
            "controller" => "adminControllers/commentaries",
            "read" => ["methods" => ["GET" => "adminReadCommentaries"]],
            "delete" => ["methods" => ["GET" => "adminDeleteCommentary"]]
        ],
        "businesses" => [
            "controller" => "adminControllers/businesses",
            "read" => ["methods" => ["GET" => "adminReadBusinesses"]],
            "delete" => ["methods" => ["GET" => "adminDeleteBusiness"]]
        ],
        "businessesCategories" => [
            "controller" => "adminControllers/businessesCategories",
            "read" => ["methods" => ["GET" => "adminReadBusinessesCategories"]],
            "add" => ["methods" => ["POST" => "adminAddBusinessesCategories"]],
            "delete" => ["methods" => ["GET" => "adminDeleteBusinessCategory"]]
        ],

    ]
];

$requestMethod = $_SERVER["REQUEST_METHOD"];
$isInvalidRequest = false;
$controller = null;
$delegateFunction = null;
$currentRoute = $routeMapping;

foreach ($requestedRoute as $index => $routeFragment) {
    if (!array_key_exists($routeFragment, $currentRoute)) {
        $isInvalidRequest = true;
        break;
    }

    $currentRoute = $currentRoute[$routeFragment];

    if (array_key_exists("security", $currentRoute)) {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/handlers/securityHandler.php";
        $security = $currentRoute["security"];
        if (array_key_exists("authentication", $security)) call_user_func($security["authentication"]);

        if (array_key_exists("authorization", $security))
            call_user_func($security["authorization"]["method"], $security["authorization"]["role"]);
    }

    if (array_key_exists("controller", $currentRoute)) $controller = $currentRoute["controller"] . ".php";

    if ($index === count($requestedRoute) - 1 && array_key_exists("methods", $currentRoute) &&
        array_key_exists($requestMethod, $currentRoute["methods"]))
        $delegateFunction = $currentRoute["methods"][$requestMethod];
}

if ($isInvalidRequest || $controller === null) error_404_NotFound();
if ($delegateFunction === null) error_405_MethodNotAllowed();

require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/$controller";
call_user_func($delegateFunction);