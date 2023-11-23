<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAccounts(): array {
    $sql = "SELECT account_id AS accountId, username, email, password, creation_date AS creationDate, 
    last_login AS lastLogin, verified, active FROM accounts";
    $statement = getConnection()->query($sql);
    return $statement->fetchAll();
}

function getAccountByUsername($username): array {
    $sqlAccount = "SELECT account_id AS accountId, username, email, password, creation_date AS creationDate FROM accounts
    WHERE username = :username";
    $sqlAuthorities = "SELECT a.authority_id authorityId, role FROM authorities_granted ag
    INNER JOIN authorities a ON ag.authority_id = a.authority_id
    WHERE account_id = :account_id";

    $connection = getConnection();
    $stAccount = $connection->prepare($sqlAccount);
    $stAuthorities = $connection->prepare($sqlAuthorities);

    $stAccount->bindValue("username", $username);
    $stAccount->execute();
    if ($stAccount->rowCount() === 0) throw new PDOException("No account found");
    $userAccount = $stAccount->fetch();

    $stAuthorities->bindValue("account_id", $userAccount["accountId"], PDO::PARAM_INT);
    $stAuthorities->execute();
    $userAccount["authorities"] = $stAuthorities->fetchAll();
    return $userAccount;
}

function persistAccount($username, $email, $password): void {
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

function updateAccount($accountId, $username, $email, $password): void {
    try {
        $sql = "UPDATE accounts set username = :username, email = :email, password = :password 
                WHERE account_id = :account_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue('username', $username);
        $statement->bindValue('email', $email);
        $statement->bindValue('password', $password);
        $statement->bindValue('account_id', $accountId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not add account");
    } catch (PDOException $exception) {
        if ($exception->getCode() == 23000) {
            if (str_contains("username", $exception->getMessage()))
                throw new Exception("Username not unique");
            if (str_contains("email", $exception->getMessage()))
                throw new Exception("Email not unique");
        }
        throw new Exception("Could not update account");
    }
}

function deleteAccount($accountId): void {
    try {
        $sql = "DELETE FROM accounts WHERE account_id = :accountId";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue('accountId', $accountId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0)
            throw new PDOException("Could not delete account");
    } catch (PDOException $exception) {
        throw new Exception("Could not delete account");
    }
}