<?php

function adminReadAccounts(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/accountDB.php";
    $accounts = getAllAccounts();
    $authorities = getAllAuthorities();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminAccounts.view.php";
}

function adminDeleteAccount(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/accountDB.php";
    $accountId = $_GET["account_id"];
    try {
        deleteAccount($accountId);
        header("Location: /admin/accounts/read", true, 303);
    } catch (Exception $exception) {
        error_500_InternalServerError();
    }
}

function adminUpdateAccountAuthorities(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/accountDB.php";
    $accountId = $_POST["account_id"];
    if (!empty($_POST["authorities_id"])) $authoritiesId = $_POST["authorities_id"];
    else $authoritiesId = null;
    try {
        updateAccountAuthorities($accountId, $authoritiesId);
        header("Location: /admin/accounts/read", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {error_500_InternalServerError();}
}