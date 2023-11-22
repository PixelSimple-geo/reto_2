<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/sessionHandler.php";

function validateRequiredParameters(array $parameters, $source = "POST"): void {
    $source = strtoupper($source);
    $requestData = ($source === "GET") ? $_GET : $_POST;
    foreach ($parameters as $parameter)
        if (empty($requestData[$parameter])) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_400.view.php";
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

    if (array_key_exists("controller", $currentRoute)) {
        $controller = $currentRoute["controller"] . ".php";
    }

    if ($index === count($requestedRoute) - 1 && array_key_exists("methods", $currentRoute) &&
        array_key_exists($requestMethod, $currentRoute["methods"])) {
        $delegateFunction = $currentRoute["methods"][$requestMethod];
    }
}

if ($isInvalidRequest || $controller === null || $delegateFunction === null) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_404.view.php";
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/$controller";
call_user_func($delegateFunction);