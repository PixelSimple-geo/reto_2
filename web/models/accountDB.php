<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAccounts() :array {
    try {
        $sql = "SELECT account_id AS accountId, username, email, password, creation_date AS creationDate, 
        last_login AS lastLogin, verified, active FROM accounts";
        $statement = getConnection()->query($sql);
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        throw $exception;
    }
}

function getAccountByUsername($username) :array {
    try {
        $sql = "SELECT account_id AS accountId, username, email, password, creation_date AS creationDate FROM accounts
        WHERE username = :username";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("username", $username);
        $statement->execute();
        if ($statement->rowCount() === 0)
            throw new PDOException("No account found");
        return $statement->fetchAll()[0];
    } catch (PDOException $exception) {
        error_log("Database error: [$username] " . $exception->getMessage());
        throw $exception;
    }
}

function persistAccount($username, $email, $password) :void {
    try {
        $sql = "INSERT INTO accounts(username, email, password) VALUES(:username, :email, :password)";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue('username', $username, PDO::PARAM_STR);
        $statement->bindValue('email', $email, PDO::PARAM_STR);
        $statement->bindValue('password', $password, PDO::PARAM_STR);
        $statement->execute();
        if ($statement->rowCount() === 0)
            throw new PDOException("Could not add account");
    } catch (PDOException $exception) {
        error_log("Database error: [$username, $email]" . $exception->getMessage());
        throw $exception;
    }
}

function updateAccount($accountId, $username, $email, $password) :void {
    try {
        $sql = "UPDATE accounts set username = :username, email = :email, password = :password 
                WHERE account_id = :account_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue('username', $username);
        $statement->bindValue('email', $email);
        $statement->bindValue('password', $password);
        $statement->bindValue('account_id', $accountId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0)
            throw new PDOException("Could not add account");
    } catch (PDOException $exception) {
        error_log("Database error: [$username, $email]" . $exception->getMessage());
        throw $exception;
    }
}

function deleteAccount($accountId) :void {
    try {
        $sql = "DELETE FROM accounts WHERE account_id = :accountId";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue('accountId', $accountId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0)
            throw new PDOException("Could not delete account");
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId]" . $exception->getMessage());
        throw $exception;
    }
}