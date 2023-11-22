<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

function validateRequiredParameters(array $parameters, $source = "POST"): void {
    $source = strtoupper($source);
    $requestData = ($source === "GET") ? $_GET : $_POST;
    foreach ($parameters as $parameter)
        if (empty($requestData[$parameter])) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_400_.view.php";
            die();
        }
}


startSession();
try {
    $userAccount = getUserAccountFromSession();
} catch (RuntimeException $exception) {
    $userAccount = null;
}

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
        "controller" => "mainController",
        "methods" => [
            "GET" => "logout"
        ]
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
        "methods" => [
            "GET" => "history"
        ]
    ],
    "contact" => [
        "controller" => "mainController",
        "methods" => [
            "GET" => "contact"
        ]
    ],
    "index" => [
        "controller" => "mainController",
        "methods" => [
            "GET" => "index"
        ]
    ],
    "account" => [
        "controller" => "accountController",
        "security" => [
            "authentication" => "authenticate"
        ],
        "methods" => [
            "GET" => "getProfile",
            "POST" => "postProfile",
            "DELETE" => "deleteUserAccount"
        ]
    ],
    "businesses" => [
        "controller" => "businessesController",
        "business" => [
            "methods" => [
                "GET" => "getBusinessPage"
            ]
        ],
        "all" => [
            "methods" => [
                "GET" => "getBusinesses"
            ]
        ],
        "crud" => [
            "security" => [
              "authentication" => "authenticate"
            ],
            "all" => [
                "methods" => [
                    "GET" => "getBusinessesCrudReadAll"
                ]
            ],
            "business" => [
                "methods" => [
                    "GET" => "getBusinessesCrudRead"
                ]
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
                "methods" => [
                    "GET" => "getBusinessesCrudDelete"
                ]
            ]
        ],
        "advertCategory" => [
            "security" => [
              "authentication" => "authenticate"
            ],
            "add" => [
                "methods" => [
                    "POST" => "postBusinessesAdvertCategoryCrudAdd"
                ]
            ],
            "delete" => [
                "methods" => [
                    "GET" => "deleteBusinessesAdvertCategoryCrudDelete"
                ]
            ]
        ]
    ],
    "adverts" => [
        "controller" => "advertsController",
        "advert" => [],
        "all" => [],
        "crud" => [
            "security" => [
                "authentication" => "authenticate"
            ],
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
                "methods" => [
                    "GET" => "getAdvertsCrudDelete"
                ]
            ]
        ]
    ],
    "articles" => [
        "controller" => "articlesController",
        "article" => [
            "methods" => [
                "GET" => "getArticleById"
            ]
        ],
        "all" => [
            "methods" => [
                "GET" => "getArticles"
            ]
        ],
        "crud" => [
            "security" => [
                "authentication" => "authenticate",
                "authorization" => [
                    "method" => "authorize",
                    "role" => "publisher"
                ]
            ],
            "all" => [
                "methods" => [
                    "GET" => "getArticlesCrudReadAll"
                ]
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
                "methods" => [
                    "GET" => "getArticlesCrudDelete"
                ]
            ]
        ]
    ],
    "reviews" => [
        "controller" => "reviewsController",
        "crud" => [
            "security" => [
                "authentication" => "authenticate"
            ],
            "add" => [
                "methods" => [
                    "POST" => "postReviewCrudAdd"
                ]
            ]
        ]
    ],
    "likes" => [
        "controller" => "reviewsController",
        "crud" => [
            "security" => [
              "authentication" => "authenticate"
            ],
            "add" => [
                "methods" => [
                    "POST" => "postReviewLikeCrudAdd"
                ]
            ]
        ]
    ],
    "products" => [
        "controller" => "advertsController",
        "methods" => [
            "GET" => "getAdverts"
        ]
    ],
    "commentaries" => [
        "controller" => "commentariesController",
        "crud" => [
            "security" => [
              "authentication" => "authenticate"
            ],
            "add" => [
                "methods" => [
                    "POST" => "postCommentaryCrudAdd"
                ]
            ]
        ]
    ],
    "commentariesLikes" => [
        "controller" => "commentariesController",
        "crud" => [
            "security" => [
              "authentication" => "authenticate"
            ],
            "add" => [
                "methods" => [
                    "POST" => "postCommentaryLikeCrudAdd"
                ]
            ]
        ]
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
        if (array_key_exists("authentication", $security)) {
            call_user_func($security["authentication"]);
        }

        if (array_key_exists("authorization", $security)) {
            call_user_func($security["authorization"]["method"], $security["authorization"]["role"]);
        }
    }

    if (array_key_exists("controller", $currentRoute)) {
        $controller = $currentRoute["controller"] . ".php";
    }

    if ($index === count($requestedRoute) - 1 && array_key_exists("methods", $currentRoute) &&
        array_key_exists($requestMethod, $currentRoute["methods"])) {
        $delegateFunction = $currentRoute["methods"][$requestMethod];
    }
}

if ($isInvalidRequest || $controller === null || $delegateFunction === null) {
    http_response_code(404);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_404_.view.php";
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/$controller";
call_user_func($delegateFunction);