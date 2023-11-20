<?php

function index(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";

    try {
        $userAccount = getUserAccountFromSession();
        $adverts = getAllAdverts();
    } catch (Exception $exception) {
        $userAccount = null;
    }
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/index.view.php";
}

function logout(): void {
    destroySession();
    header("Location: /index", true, 303);
}

function history(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/history.view.php";
}

function contact(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/contact.view.php";
}


