<?php

function perfil() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    startSession();
    $userAccount = getUserAccountSession();
    if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {

        $errorMessage = null;
        try {
            updateAccount($userAccount["accountId"], $_POST["username"], $_POST["email"], $_POST["password"]);
            $userAccount["username"] = $_POST["username"];
            $userAccount["email"] = $_POST["email"];
            $userAccount["password"] = $_POST["password"];
        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
        }
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/perfil.view.php";
}
