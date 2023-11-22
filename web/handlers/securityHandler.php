<?php

function authenticate() {
    global $userAccount;
    if ($userAccount === null) {
        http_response_code(401);
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_401_.view.php";
        die();
    }
}


function authorize($role) {
    global $userAccount;
    foreach ($userAccount["authorities"] as $authority) {
        if ($authority["role"] === $role) return;
    }
    http_response_code(403);
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_403_.view.php";
    die();
}
