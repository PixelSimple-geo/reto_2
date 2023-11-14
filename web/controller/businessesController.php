<?php


function postBusiness() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (isset($_POST["name"]) && isset($_POST["description"])) {
        $userAccount = getUserAccountSession();
        try {
            $name = $_POST["name"];
            $description = $_POST["description"];
            persistBusiness($userAccount["accountId"], $name, $description);
            //
        } catch (Exception $exception) {

        }
    }
}