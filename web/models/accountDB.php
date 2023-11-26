<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAllAccounts(): array {
    $sqlAccounts = "SELECT account_id accountId, username, email, password, creation_date creationDate, 
    last_login lastLogin, verified, active FROM accounts";
    $sqlAuthorities = "SELECT a.authority_id authorityId, a.role FROM authorities_granted ag 
    INNER JOIN authorities a ON ag.authority_id = a.authority_id WHERE account_id = :account_id";
    $connection = getConnection();
    $accounts = $connection->query($sqlAccounts)->fetchAll();
    $stAuthorities = $connection->prepare($sqlAuthorities);

    foreach ($accounts as &$account) {
        $stAuthorities->bindValue("account_id",$account["accountId"], PDO::PARAM_INT);
        $stAuthorities->execute();
        $account["authorities"] = $stAuthorities->fetchAll();
    }

    return $accounts;
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

function updateAccountAuthorities($accountId, array | null $authoritiesIds): void {
    $delete = "DELETE FROM authorities_granted WHERE account_id = :account_id";
    $insert = "INSERT INTO authorities_granted(authority_id, account_id) VALUES(:authority_id, :account_id)";
    $connection = getConnection();
    try {
        $stDelete = $connection->prepare($delete);
        $stInsert = $connection->prepare($insert);

        $stDelete->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $stDelete->execute();
        if (!empty($authoritiesIds))
            foreach ($authoritiesIds as $authorityId) {
                $stInsert->bindValue("authority_id", $authorityId, PDO::PARAM_INT);
                $stInsert->bindValue("account_id", $accountId, PDO::PARAM_INT);
                $stInsert->execute();
            }
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") throw new ValueError("constraint violation");
        throw new Exception("internal server error");
    }
}

function deleteAccount($accountId): void {
    $sql = "DELETE FROM accounts WHERE account_id = :accountId";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue('accountId', $accountId, PDO::PARAM_INT);
    $statement->execute();
}

function getAllAuthorities(): array {
    return getConnection()->query("SELECT authority_id authorityId, role FROM authorities")->fetchAll();
}