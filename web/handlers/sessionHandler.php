<?php

function isSessionActive(): bool {
    return session_status() === PHP_SESSION_ACTIVE;
}

function startSession() :void {
    if (!isSessionActive()) session_start();
}

function destroySession() :void {
    if (isSessionActive()) session_destroy();
}

function addUserAccountToSession(array $userAccount) :void {
    $_SESSION["userAccount"] = $userAccount;
}

function getUserAccountFromSession(): array | null {
    if (!isset($_SESSION["userAccount"])) return null;
    return $_SESSION["userAccount"];
}

function isUserAccountInSession(): bool {
    return isset($_SESSION["userAccount"]);
}
