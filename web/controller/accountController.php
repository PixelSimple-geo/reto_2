<?php

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

function getSignIn() :void {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/register.view.php";
}

function postSignIn() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    try {
        persistAccount($username, $email, $password);
        header("HTTP/1.1 303 See Other");
        header("Location: /index");
    } catch (PDOException $exception) {
        $errorMessage = "No se ha podido registrar la cuenta. Si el error persiste contacta con el soporte";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/register.view.php";
    }
}

function getProfile() :void {
    $userAccount = getUserAccountFromSession();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/profile.view.php";
}

function postProfile() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    $errorMessage = null;
    $userAccount = getUserAccountFromSession();

    $usernameTemp = $userAccount["username"];
    $emailTemp = $userAccount["email"];
    $passwordTemp = $userAccount["password"];

    if (isset($_POST["password"]) && $userAccount["password"] === $_POST["password"]) {
        if (!empty($_POST["username"]))
            $userAccount["username"] = $_POST["username"];
        if (!empty($_POST["email"]))
            $userAccount["email"] = $_POST["email"];
        if (!empty($_POST["password_new"]))
            $userAccount["password"] = $_POST["password_new"];
        try {
            updateAccount($userAccount["accountId"], $userAccount["username"], $userAccount["email"],
                $userAccount["password"]);
        } catch (Exception $exception) {
            $errorMessage = "Hubo un error. No se ha podido actualizar la cuenta";
            $userAccount["username"] = $usernameTemp;
            $userAccount["email"] = $emailTemp;
            $userAccount["password"] = $passwordTemp;
        }
    } else $errorMessage = "Contraseña no válida";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/profile.view.php";
}
