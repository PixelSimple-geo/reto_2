<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAccounts(): array {
    return getConnection()->query("SELECT account_id accountId, username, email, password, creation_date 
    creationDate, last_login lastLogin, verified, active FROM accounts")->fetchAll();
}

function getAccountByUsername($username) :array {
    $sql = "SELECT account_id accountId, username, email, password, creation_date creationDate FROM accounts
    WHERE username = :username";
    $sqlAuthorities = "SELECT a.authority_id authorityId, role FROM authorities_granted ag
    INNER JOIN authorities a ON ag.authority_id = a.authority_id WHERE account_id = :account_id";

    $connection = getConnection();
    $statement = $connection->prepare($sql);
    $statementAuthorities = $connection->prepare($sqlAuthorities);

    $statement->bindValue("username", $username);
    $statement->execute();
    if ($statement->rowCount() === 0) throw new Exception("no row was affected");
    $userAccount = $statement->fetch();

    $statementAuthorities->bindValue("account_id", $userAccount["accountId"], PDO::PARAM_INT);
    $statementAuthorities->execute();
    $userAccount["authorities"] = $statementAuthorities->fetchAll();
    return $userAccount;
}

function persistAccount($username, $email, $password): void {
    $sql = "INSERT INTO accounts(username, email, password) VALUES(:username, :email, :password)";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue('username', $username);
        $statement->bindValue('email', $email);
        $statement->bindValue('password', $password);
        $statement->execute();
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") {
            if (str_contains($exception->getMessage(), "username")) {
                throw new Exception("[username] unique constraint violation");
            }
            if (str_contains($exception->getMessage(), "email"))
                throw new Exception("[email] unique constraint violation");
            throw new ValueError("constraint violation");
        }
        throw new Exception("internal server error");
    }
}

function updateAccount($accountId, $username, $email, $password): void {
    $sql = "UPDATE accounts set username = :username, email = :email, password = :password 
                WHERE account_id = :account_id";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue('username', $username);
        $statement->bindValue('email', $email);
        $statement->bindValue('password', $password);
        $statement->bindValue('account_id', $accountId, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") {
            if (str_contains($exception->getMessage(), "username")) {
                throw new Exception("[username] unique constraint violation");
            }
            if (str_contains($exception->getMessage(), "email"))
                throw new Exception("[email] unique constraint violation");
            throw new ValueError("constraint violation");
        }
        throw new Exception("internal server error");
    }
}

function deleteAccount($accountId): void {
    $sql = "DELETE FROM accounts WHERE account_id = :accountId";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue('accountId', $accountId, PDO::PARAM_INT);
    $statement->execute();
}