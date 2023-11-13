<?php

function index() {

}

function login() {
    require_once "../models/accountDB.php";
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        try {
            $account = getAccountByUsername($username);
            if ($password === $account["password"])
                include_once "../views/index.php";
            else include_once "../views/login.php";
        } catch (PDOException $exception) {
            include_once "../views/login.php";
        }
    } else include_once "../views/login.php";
}

