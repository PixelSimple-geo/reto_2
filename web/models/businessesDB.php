<?php

function getBusiness($businessId) {
    try {
        $sql = "SELECT business_id AS businessId, name, description FROM businesses WHERE business_id = :business_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        if ($statement->rowCount() === 0) throw new PDOException("No business found");
        return $statement->fetchAll()[0];
    } catch (PDOException $exception) {
        error_log("Database error: [$businessId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllAccountBusinesses($accountId) :array {
    try {
        $sql = "SELECT business_id AS businessId, name, description FROM businesses WHERE account_id = :account_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId] " . $exception->getMessage());
        throw $exception;
    }
}

function persistBusiness($accountId, $name, $description) :void {
    try {
        $sql = "INSERT INTO businesses(business_id, account_id, name, description) 
        VALUES (DEFAULT, :account_id, :name, :description)";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("name", $name, PDO::PARAM_STR);
        $statement->bindValue("description", $description, PDO::PARAM_STR);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not persist business");
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId, $name] " . $exception->getMessage());
        throw $exception;
    }
}

function deleteBusiness($accountId, $business_id) :void {
    try {
        $sql = "DELETE FROM businesses WHERE account_id = :account_id AND business_id = :business_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("business_id", $business_id, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not delete business");
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId, $business_id] " . $exception->getMessage());
        throw $exception;
    }
}