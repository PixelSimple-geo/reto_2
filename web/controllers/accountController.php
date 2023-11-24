<?php

function getLogin() :void {
    if (isUserAccountInSession()) header("Location: /index", true, 303);
    else include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
}

function postLogin() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400_.view.php";
        return;
    }
    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
        $userAccount = getAccountByUsername($username);
        if (password_verify($password, $userAccount["password"])) {
            startSession();
            addUserAccountToSession($userAccount);
            header("Location: /index", true, 303);
        } else {
            $errorMessage = "La contraseña no es válida";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
        }
    } catch (PDOException $exception) {
        $errorMessage = "Usuario no encontrado";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
    }
}

function getSignIn() :void {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/signIn.php";
}

function postSignIn() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400_.view.php";
        return;
    }
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];
    try {
        persistAccount($username, $email, $password);
        header("Location: /index", true, 303);
    } catch (PDOException $exception) {
        if (str_contains($exception->getMessage(), "username"))
            $errorMessage = "El nombre de usuario ya está en uso";
        else if (str_contains($exception->getMessage(), "email"))
            $errorMessage = "El correo electrónico ya está vinculada a otra cuenta";
        else
            $errorMessage = "Se ha producido un error al intentar registrar tu cuenta. Si el error persiste contacta
            con el soporte.";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/signIn.php";
    }
}

function getProfile() :void {
    try {
        $userAccount = getUserAccountFromSession();
    } catch (RuntimeException $exception) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_404_.view.php";
        return;
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/profile.view.php";
}

function postProfile() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (empty($_POST["password"])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400_.view.php";
        return;
    }
    $userAccount = getUserAccountFromSession();

    $usernameTemp = $userAccount["username"];
    $emailTemp = $userAccount["email"];
    $passwordTemp = $userAccount["password"];

    if ($userAccount["password"] === $_POST["password"]) {
        if (!empty($_POST["username"]))
            $userAccount["username"] = $_POST["username"];
        if (!empty($_POST["email"]))
            $userAccount["email"] = $_POST["email"];
        if (!empty($_POST["password_new"]))
            $userAccount["password"] = $_POST["password_new"];
        try {
            updateAccount($userAccount["accountId"], $userAccount["username"], $userAccount["email"],
                $userAccount["password"]);
        } catch (PDOException $exception) {
            if (str_contains($exception->getMessage(), "username"))
                $errorMessage = "El nombre de usuario ya está en uso";
            else if (str_contains($exception->getMessage(), "email"))
                $errorMessage = "El correo electrónico ya está vinculada a otra cuenta";
            else $errorMessage = "Se ha producido un error al intentar actualizar tu cuenta. Si el error persiste
            contacta con soporte";
            $userAccount["username"] = $usernameTemp;
            $userAccount["email"] = $emailTemp;
            $userAccount["password"] = $passwordTemp;
        }
    } else $errorMessage = "Contraseña no es válida";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/profile.view.php";
}

function deleteUserAccount() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    try {
        $userAccount = getUserAccountFromSession();
        deleteAccount($userAccount["accountId"]);
    } catch (PDOException $exception) {
        $errorMessage = "Se ha producido un error al intentar eliminar tu cuenta. Si el error persiste contacta con
        soporte";
    } catch (RuntimeException $exception) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400_.view.php";
    }
}