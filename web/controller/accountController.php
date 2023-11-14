<?php

function getProfile() :void {
    $userAccount = getUserAccountFromSession();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/perfil.view.php";
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

    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/perfil.view.php";
}
