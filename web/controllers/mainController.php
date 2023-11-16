<?php

function index() :void {
    try {
        $userAccount = getUserAccountFromSession();
    } catch (Exception $exception) {
        $userAccount = null;
    }
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/index.view.php";
}

function logout() :void {
    destroySession();
    header("Location: /index", true, 303);
}


