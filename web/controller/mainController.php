<?php

function login() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        try {
            $account = getAccountByUsername($username);
            if ($password === $account[0]["password"]) {
                startSession();
                addUserAccountSession($account);
                include_once $_SERVER['DOCUMENT_ROOT'] . "/views/index.php";
            }
            else {
                $errorMessage = "La contraseña no es válida";
                include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
            }
        } catch (PDOException $exception) {
            $errorMessage = "Usuario no encontrado";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
        }
    } else include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
}

function register() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        try {
            addAccount($username, $email, $password);
            $message = "Enhorabuena su cuenta se ha registrado correctamente";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/index.php";
        } catch (PDOException $exception) {
            $errorMessage = "No se ha podido registrar la cuenta. Si el error persiste contacta con el soporte";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/register.view.php";
        }
    } else {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/register.view.php";
    }
}