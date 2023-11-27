<?php

function index(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";

    try {
        $adverts = getAllAdverts();
    } catch (PDOException $exception) {
        //TODO
    }
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/index.view.php";
}



function history(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/history.view.php";
}

function contact(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/contact.view.php";
}

function postContact(): void {
    validateRequiredParameters(["name", "email", "subject", "message"]);
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $message .= "<br><br>" . $email;
    require_once $_SERVER["DOCUMENT_ROOT"] . "/handlers/emailHandler.php";
    try {
        sendEmail($subject, $message);
        header("Location: /contact", true, 303);
    } catch (Exception $exception){error_500_InternalServerError();}
}

function showCookiePolicy(){
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/cookiePolicy.php";
}
