<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getBusiness($businessId) {
    try {
        $sql = "SELECT business_id AS businessId, name, description FROM businesses WHERE business_id = :business_id";
        $connection = getConnection();
        $statement = $connection->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() === 0) throw new PDOException("No business found");
        $business = $statement->fetchAll()[0];

        $sqlCategory = "SELECT bcm.category_id AS categoryId, name FROM businesses_categories_mapping AS bcm
        INNER JOIN businesses_categories AS bbc ON bcm.category_id = bbc.category_id
        WHERE business_id = :business_id";
        $statementCategory = $connection->prepare($sqlCategory);
        $statementCategory->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementCategory->execute();
        $business["category"] = $statementCategory->fetchAll()[0];

        $sqlContacts = "SELECT contact_id AS contactId, type, value FROM business_contacts 
                                            WHERE business_id = :business_id";
        $statementContacts = $connection->prepare($sqlContacts);
        $statementContacts->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementContacts->execute();
        $business["contacts"] = $statementContacts->fetchAll();

        $sqlAddresses = "SELECT address_id AS addressId, address, postal_code AS postalCode
        FROM addresses WHERE business_id = :business_id";
        $statementAddresses = $connection->prepare($sqlAddresses);
        $statementAddresses->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementAddresses->execute();
        $business["addresses"] = $statementAddresses->fetchAll();

        return $business;
    } catch (PDOException $exception) {
        error_log("Database error: [$businessId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllBusinesses() :array {
    try {
        $sql = "SELECT business_id AS businessId, name, description FROM businesses";
        $statement = getConnection()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error:" . $exception->getMessage());
        throw $exception;
    }
}

function getAllAccountBusinesses($accountId) :array {
    try {
        $sql = "SELECT business_id AS businessId, name, description FROM businesses WHERE account_id = :account_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId] " . $exception->getMessage());
        throw $exception;
    }
}

function persistBusiness($accountId, $name, $description, $categoryId, array $contacts, array $addresses) :void {
    try {
        $sql = "INSERT INTO businesses(business_id, account_id, name, description) 
        VALUES (DEFAULT, :account_id, :name, :description)";

        $connection = getConnection();
        $connection->beginTransaction();

        $statement = $connection->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("name", $name, PDO::PARAM_STR);
        $statement->bindValue("description", $description, PDO::PARAM_STR);
        $statement->execute();

        $businessPrimaryKey = $connection->lastInsertId();
        if (isset($categoryId)) {
            $sqlBusinessCategory = "INSERT INTO businesses_categories_mapping(category_id, business_id) 
            VALUES (:category_id, :business_id)";
            $statementCategory = $connection->prepare($sqlBusinessCategory);
            $statementCategory->bindValue("category_id", $categoryId, PDO::PARAM_INT);
            $statementCategory->bindValue("business_id", $businessPrimaryKey, PDO::PARAM_INT);
            $statementCategory->execute();
        }

        if (count($contacts) > 0) {
            $sqlContacts = "INSERT INTO business_contacts(business_id, type, value) 
            VALUES(:business_id, :type, :value)";
            $statementContacts = $connection->prepare($sqlContacts);
            foreach ($contacts as $contact) {
                $statementContacts->bindValue("business_id", $businessPrimaryKey, PDO::PARAM_INT);
                $statementContacts->bindValue("type", $contact["type"]);
                $statementContacts->bindValue("value", $contact["value"]);
                $statementContacts->execute();
            }
        }

        if (count($addresses) > 0) {
            $sqlAddresses = "INSERT INTO addresses(business_id, address, postal_code) 
            VALUES(:business_id, :address, :postal_code)";
            $statementAddresses = $connection->prepare($sqlAddresses);
            foreach ($addresses as $address) {
                $statementAddresses->bindValue("business_id", $businessPrimaryKey, PDO::PARAM_INT);
                $statementAddresses->bindValue("address", $address["address"]);
                $statementAddresses->bindValue("postal_code", $address["postalCode"], PDO::PARAM_INT);
                $statementAddresses->execute();
            }
        }
        $connection->commit();
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId, $name] " . $exception->getMessage());
        throw $exception;
    }
}

function updateBusiness($accountId, $businessId, $name, $description, $categoryId,
                        array $contacts, array $addresses) :void {
    try {
        $sql = "UPDATE businesses SET name = :name, description = :description 
                  WHERE account_id = :account_id AND business_id = :business_id";

        $connection = getConnection();
        $connection->beginTransaction();

        $statement = $connection->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("name", $name);
        $statement->bindValue("description", $description);
        $statement->execute();

        if (isset($categoryId)) {
            $sqlBusinessCategory = "UPDATE businesses_categories_mapping SET category_id = :category_id 
                                     WHERE business_id = :business_id";
            $statementCategory = $connection->prepare($sqlBusinessCategory);
            $statementCategory->bindValue("category_id", $categoryId, PDO::PARAM_INT);
            $statementCategory->bindValue("business_id", $businessId, PDO::PARAM_INT);
            $statementCategory->execute();
        }

        $sqlContactsDelete = "DELETE FROM business_contacts WHERE business_id = :business_id";
        $statementContactsDelete = getConnection()->prepare($sqlContactsDelete);
        $statementContactsDelete->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementContactsDelete->execute();

        if (count($contacts) > 0) {
            $sqlContacts = "INSERT INTO business_contacts(business_id, type, value) 
            VALUES(:business_id, :type, :value)";
            $statementContacts = $connection->prepare($sqlContacts);
            foreach ($contacts as $contact) {
                $statementContacts->bindValue("business_id", $businessId, PDO::PARAM_INT);
                $statementContacts->bindValue("type", $contact["type"]);
                $statementContacts->bindValue("value", $contact["value"]);
                $statementContacts->execute();
            }
        }

        $sqlAddressesDelete = "DELETE FROM addresses WHERE business_id = :business_id";
        $statementAddressesDelete = getConnection()->prepare($sqlAddressesDelete);
        $statementAddressesDelete->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementAddressesDelete->execute();

        if (count($addresses) > 0) {
            $sqlAddresses = "INSERT INTO addresses(business_id, address, postal_code) 
            VALUES(:business_id, :address, :postal_code)";
            $statementAddresses = $connection->prepare($sqlAddresses);
            foreach ($addresses as $address) {
                $statementAddresses->bindValue("business_id", $businessId, PDO::PARAM_INT);
                $statementAddresses->bindValue("address", $address["address"]);
                $statementAddresses->bindValue("postal_code", $address["postalCode"], PDO::PARAM_INT);
                $statementAddresses->execute();
            }
        }
        $connection->commit();
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

function getAllBusinessCategories() :array {
    try {
        $sql = "SELECT category_id AS categoryId, name FROM businesses_categories;";
        $statement = getConnection()->query($sql);
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        throw $exception;
    }
}

function getAllBusinessAdvertCategories($businessId): array {
    try {
        $sql = "SELECT category_id AS categoryId, name FROM businesses_advert_categories 
                                       WHERE business_id = :business_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        throw $exception;
    }
}