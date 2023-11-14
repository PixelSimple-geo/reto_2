<?php

function getAccounts() :array {
    try {
        $sql = "SELECT account_id AS accountId, username, email, password, creation_date AS creationDate, 
       last_login AS lastLogin, verified, active FROM accounts";
        $statement = getConnection()->query($sql);
        if ($statement->rowCount() === 0)
            throw new PDOException("No accounts found");
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
            throw new PDOException("No account found with [$username]");
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        echo $exception->getMessage();
        throw $exception;
    }
}

function addAccount($username, $email, $password) :void {
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
        error_log("Database error: " . $exception->getMessage());
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
            throw new PDOException("No account with id" . $accountId . " found");
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        throw $exception;
    }
}