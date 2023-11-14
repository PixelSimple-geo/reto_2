<?php

function index() :void {
    try {
        $userAccount = getUserAccountFromSession();
    } catch (Exception $exception) {
        $userAccount = null;
    }
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/index.view.php";
}

function getLogin() :void {
    if (isUserAccountInSession()) header("Location: /index", true, 303);
    else include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
}

function postLogin() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
        $userAccount = getAccountByUsername($username);
        if ($password === $userAccount["password"]) {
            startSession();
            addUserAccountToSession($userAccount);
            header("Location: /index", true, 303);
        }
        else {
            $errorMessage = "La contraseña no es válida";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
        }
    } catch (PDOException $exception) {
        $errorMessage = "Usuario no encontrado";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
    }
}

function logout() :void {
    destroySession();
    header("Location: /index", true, 303);
}

function register() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        try {
            persistAccount($username, $email, $password);
            $message = "Enhorabuena su cuenta se ha registrado correctamente";
            header("HTTP/1.1 303 See Other");
            header("Location: /index");
        } catch (PDOException $exception) {
            $errorMessage = "No se ha podido registrar la cuenta. Si el error persiste contacta con el soporte";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/register.view.php";
        }
    } else include_once $_SERVER['DOCUMENT_ROOT'] . "/views/register.view.php";
}
