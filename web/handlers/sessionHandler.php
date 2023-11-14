<?php

function startSession() :void {
    session_start();
}

function getUserAccountSession() :array {
    if (!isset($_SESSION["userAccount"]))
        throw new RuntimeException("No user account found");
    return $_SESSION["userAccount"];
}

function addUserAccountSession($userAccount) :void {
    if (!is_array($userAccount))
        throw new RuntimeException("Not a valid argument");
    if (isset($_SESSION["userAccount"]))
        throw new RuntimeException("There is already an existing account");
    $_SESSION["userAccount"] = $userAccount;
}

function destroySession() :void {
    session_destroy();
}