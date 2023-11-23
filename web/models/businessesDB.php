<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getBusiness($businessId): array {
    $sqlBusiness = "SELECT business_id AS businessId, name, description FROM businesses 
                                                WHERE business_id = :business_id";
    $sqlCategory = "SELECT bcm.category_id AS categoryId, name FROM businesses_categories_mapping AS bcm
    LEFT JOIN businesses_categories AS bbc ON bcm.category_id = bbc.category_id 
                                       WHERE business_id = :business_id";
    $sqlContacts = "SELECT contact_id AS contactId, type, value FROM business_contacts 
                                        WHERE business_id = :business_id";
    $sqlAddresses = "SELECT address_id AS addressId, address, postal_code AS postalCode FROM addresses 
                                                               WHERE business_id = :business_id";
    $sqlAdvertCategories = "SELECT category_id AS categoryId, name 
    FROM businesses_advert_categories WHERE business_id = :business_id";

    $connection = getConnection();
    $stBusiness = $connection->prepare($sqlBusiness);
    $stCategory = $connection->prepare($sqlCategory);
    $stContacts = $connection->prepare($sqlContacts);
    $stAddresses = $connection->prepare($sqlAddresses);
    $stAdvertCategories = $connection->prepare($sqlAdvertCategories);

    $stBusiness->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $stBusiness->execute();
    if ($stBusiness->rowCount() === 0) throw new Exception("No business found");
    $business = $stBusiness->fetch();

    $stCategory->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $stCategory->execute();
    $business["category"] = $stCategory->fetch();

    $stContacts->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $stContacts->execute();
    $business["contacts"] = $stContacts->fetchAll();

    $stAddresses->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $stAddresses->execute();
    $business["addresses"] = $stAddresses->fetchAll();

    $stAdvertCategories->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $stAdvertCategories->execute();
    $business["advertCategories"] = $stAdvertCategories->fetchAll();
    return $business;
}

function getAllBusinesses(): array {
    $sql = "SELECT business_id AS businessId, name, description FROM businesses";
    $statement = getConnection()->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
}

function getAllAccountBusinesses($accountId): array {
    $sql = "SELECT business_id AS businessId, name, description FROM businesses WHERE account_id = :account_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function persistBusiness($accountId, $name, $description, $categoryId, array $contacts, array $addresses): void {
    $sqlBusiness = "INSERT INTO businesses(business_id, account_id, name, description) 
        VALUES (DEFAULT, :account_id, :name, :description)";
    $sqlBusinessCategory = "INSERT INTO businesses_categories_mapping(category_id, business_id) 
        VALUES (:category_id, :business_id)";
    $sqlContacts = "INSERT INTO business_contacts(business_id, type, value) 
        VALUES(:business_id, :type, :value)";
    $sqlAddresses = "INSERT INTO addresses(business_id, address, postal_code) 
        VALUES(:business_id, :address, :postal_code)";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $stBusiness = $connection->prepare($sqlBusiness);
        $stCategory = $connection->prepare($sqlBusinessCategory);
        $stContacts = $connection->prepare($sqlContacts);
        $stAddresses = $connection->prepare($sqlAddresses);

        $stBusiness->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $stBusiness->bindValue("name", $name);
        $stBusiness->bindValue("description", $description);
        $stBusiness->execute();
        $businessId = $connection->lastInsertId();

        if (empty($categoryId)) throw new PDOException("No category id");
        $stCategory->bindValue("category_id", $categoryId, PDO::PARAM_INT);
        $stCategory->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $stCategory->execute();

        foreach ($contacts as $contact) {
            $stContacts->bindValue("business_id", $businessId, PDO::PARAM_INT);
            $stContacts->bindValue("type", $contact["type"]);
            $stContacts->bindValue("value", $contact["value"]);
            $stContacts->execute();
        }

        foreach ($addresses as $address) {
            $stAddresses->bindValue("business_id", $businessId, PDO::PARAM_INT);
            $stAddresses->bindValue("address", $address["address"]);
            $stAddresses->bindValue("postal_code", $address["postalCode"], PDO::PARAM_INT);
            $stAddresses->execute();
        }

        $connection->commit();
        if ($stBusiness->rowCount() === 0) throw new PDOException("Failed to update");
    } catch (PDOException $exception) {
        $connection->rollBack();
        if ($exception->getCode() == 22001 || str_contains("No category id",$exception))
            throw new Exception("Invalid parameter");
        throw new Exception("Internal server error");
    }
}

function updateBusiness($businessId, $name, $description, $categoryId, array $contacts, array $addresses) :void {
    $sqlBusiness = "UPDATE businesses SET name = :name, description = :description 
                  WHERE business_id = :business_id";
    $sqlBusinessCategory = "UPDATE businesses_categories_mapping SET category_id = :category_id 
                                     WHERE business_id = :business_id";
    $sqlContactsDelete = "DELETE FROM business_contacts WHERE business_id = :business_id";
    $sqlContacts = "INSERT INTO business_contacts(business_id, type, value) 
        VALUES(:business_id, :type, :value)";
    $sqlAddressesDelete = "DELETE FROM addresses WHERE business_id = :business_id";
    $sqlAddresses = "INSERT INTO addresses(business_id, address, postal_code) 
        VALUES(:business_id, :address, :postal_code)";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $statement = $connection->prepare($sqlBusiness);
        $statementCategory = $connection->prepare($sqlBusinessCategory);
        $statementContactsDelete = $connection->prepare($sqlContactsDelete);
        $statementContacts = $connection->prepare($sqlContacts);
        $statementAddressesDelete = $connection->prepare($sqlAddressesDelete);
        $statementAddresses = $connection->prepare($sqlAddresses);

        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("name", $name);
        $statement->bindValue("description", $description);
        $statement->execute();

        $statementCategory->bindValue("category_id", $categoryId, PDO::PARAM_INT);
        $statementCategory->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementCategory->execute();

        $statementContactsDelete->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementContactsDelete->execute();

        foreach ($contacts as $contact) {
            $statementContacts->bindValue("business_id", $businessId, PDO::PARAM_INT);
            $statementContacts->bindValue("type", $contact["type"]);
            $statementContacts->bindValue("value", $contact["value"]);
            $statementContacts->execute();
        }

        $statementAddressesDelete->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statementAddressesDelete->execute();

        foreach ($addresses as $address) {
            $statementAddresses->bindValue("business_id", $businessId, PDO::PARAM_INT);
            $statementAddresses->bindValue("address", $address["address"]);
            $statementAddresses->bindValue("postal_code", $address["postalCode"], PDO::PARAM_INT);
            $statementAddresses->execute();
        }
        $connection->commit();
    } catch (PDOException $exception) {
        $connection->rollBack();
        throw $exception;
    }
}

function deleteBusiness($business_id) :void {
    try {
        $sql = "DELETE FROM businesses WHERE business_id = :business_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $business_id, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not delete business");
    } catch (PDOException $exception) {
        error_log("Database error: [$business_id] " . $exception->getMessage());
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

function getAllBusinessesByCategory($categoryId): array {
    try {
        $sql = "SELECT b.business_id AS businessId, b.name, b.description 
                FROM businesses b
                INNER JOIN businesses_categories_mapping bcm ON b.business_id = bcm.business_id
                WHERE bcm.category_id = :category_id";

        $statement = getConnection()->prepare($sql);
        $statement->bindValue("category_id", $categoryId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        error_log("Database error: [$categoryId] " . $exception->getMessage());
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

function persistBusinessAdvertCategory($businessId, $name): void {
    try {
        $sql = "INSERT INTO businesses_advert_categories(business_id, name) VALUES(:business_id, :name)";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("name", $name);
        $statement->execute();
    } catch (PDOException $exception) {
        error_log("Database error [$businessId, $name]: " . $exception->getMessage());
        throw $exception;
    }
}

function deleteBusinessAdvertCategory($categoryId): void {
    try {
        $sql = "DELETE FROM businesses_advert_categories WHERE category_id = :category_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("category_id", $categoryId, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception) {
        error_log("Database error [$categoryId]" . $exception->getMessage());
        throw $exception;
    }
}