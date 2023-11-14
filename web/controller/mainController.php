<?php

function login() :void{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        try {
            $account = getAccountByUsername($username);
            if ($password === $account[0]["password"])
                include_once $_SERVER['DOCUMENT_ROOT'] . "/views/index.php";
            else {
                $errorMessage = "Contraseña no válida";
                include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
            }
        } catch (PDOException $exception) {
            $errorMessage = $exception->getMessage();
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
        }
    } else include_once $_SERVER['DOCUMENT_ROOT'] . "/views/login.view.php";
}

