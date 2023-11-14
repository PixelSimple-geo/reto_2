<?php

function perfil() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";

    if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {

    } else {
        $userAccount = getUserAccountSession();
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/perfil.view.php";
    }
}
