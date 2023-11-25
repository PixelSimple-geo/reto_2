<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getBusiness($businessId): array {
    $sqlBusiness = "SELECT business_id businessId, name, description, cover_img coverImg 
    FROM businesses WHERE business_id = :business_id";
    $sqlCategory = "SELECT bcm.category_id categoryId, name FROM businesses_categories_mapping bcm
    LEFT JOIN businesses_categories bc ON bcm.category_id = bc.category_id WHERE business_id = :business_id";
    $sqlContacts = "SELECT contact_id contactId, type, value FROM business_contacts WHERE business_id = :business_id";
    $sqlAddresses = "SELECT address_id addressId, address, postal_code postalCode FROM addresses 
    WHERE business_id = :business_id";
    $sqlAdvertCategories = "SELECT category_id categoryId, name FROM businesses_advert_categories 
    WHERE business_id = :business_id";

    $connection = getConnection();
    $stBusiness = $connection->prepare($sqlBusiness);
    $stCategory = $connection->prepare($sqlCategory);
    $stContacts = $connection->prepare($sqlContacts);
    $stAddresses = $connection->prepare($sqlAddresses);
    $stAdvertCategories = $connection->prepare($sqlAdvertCategories);

    $stBusiness->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $stBusiness->execute();
    if ($stBusiness->rowCount() === 0) throw new Exception("no record found");
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
    return getConnection()->query("SELECT business_id AS businessId, account_id accountId, name, description, cover_img AS coverImg FROM businesses")
        ->fetchAll();
}

function getAllAccountBusinesses($accountId): array {
    $sql = "SELECT business_id AS businessId, name, description, cover_img AS coverImg FROM businesses WHERE account_id = :account_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function persistBusiness($accountId, $name, $description, $coverImg, $categoryId, array $contacts,
                         array $addresses): void {
    $sqlBusiness = "INSERT INTO businesses(business_id, account_id, name, description, cover_img) 
    VALUES (DEFAULT, :account_id, :name, :description, :cover_img)";
    $sqlBusinessCategory = "INSERT INTO businesses_categories_mapping(category_id, business_id) 
    VALUES (:category_id, :business_id)";
    $sqlContacts = "INSERT INTO business_contacts(business_id, type, value) VALUES(:business_id, :type, :value)";
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
        $stBusiness->bindValue("cover_img", $coverImg);
        $stBusiness->execute();
        $businessId = $connection->lastInsertId();

        if (empty($categoryId)) throw new ValueError("no id");
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
            $stAddresses->bindValue("postal_code", $address["postalCode"]);
            $stAddresses->execute();
        }

        $connection->commit();
    } catch (PDOException $exception) {
        $connection->rollBack();
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") {
            if (str_contains("name", $exception->getMessage()))
                throw new Exception("[name] unique constraint violation");
            if (str_contains("foreign key", $exception->getMessage()))
                throw new ValueError("foreign key constraint violation");
            throw new ValueError("constraint violation");
        }
        throw new Exception("internal server error");
    }
}

function updateBusiness($businessId, $name, $description, $coverImg, $categoryId,
                        array $contacts, array $addresses): void {
    $sqlBusiness = "UPDATE businesses SET name = :name, description = :description, cover_img = :cover_img WHERE business_id = :business_id";
    $sqlCategory = "UPDATE businesses_categories_mapping SET category_id = :category_id 
    WHERE business_id = :business_id";
    $sqlContactsDelete = "DELETE FROM business_contacts WHERE business_id = :business_id";
    $sqlContacts = "INSERT INTO business_contacts(business_id, type, value) VALUES(:business_id, :type, :value)";
    $sqlAddressesDelete = "DELETE FROM addresses WHERE business_id = :business_id";
    $sqlAddresses = "INSERT INTO addresses(business_id, address, postal_code) 
    VALUES(:business_id, :address, :postal_code)";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $stBusiness = $connection->prepare($sqlBusiness);
        $stCategory = $connection->prepare($sqlCategory);
        $stContactsDelete = $connection->prepare($sqlContactsDelete);
        $stContacts = $connection->prepare($sqlContacts);
        $stAddressesDelete = $connection->prepare($sqlAddressesDelete);
        $stAddresses = $connection->prepare($sqlAddresses);

        $stBusiness->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $stBusiness->bindValue("name", $name);
        $stBusiness->bindValue("description", $description);
        $stBusiness->bindValue("cover_img", $coverImg);
        $stBusiness->execute();

        if (empty($categoryId)) throw new ValueError("No id");
        $stCategory->bindValue("category_id", $categoryId, PDO::PARAM_INT);
        $stCategory->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $stCategory->execute();

        $stContactsDelete->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $stContactsDelete->execute();

        foreach ($contacts as $contact) {
            $stContacts->bindValue("business_id", $businessId, PDO::PARAM_INT);
            $stContacts->bindValue("type", $contact["type"]);
            $stContacts->bindValue("value", $contact["value"]);
            $stContacts->execute();
        }

        $stAddressesDelete->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $stAddressesDelete->execute();

        foreach ($addresses as $address) {
            $stAddresses->bindValue("business_id", $businessId, PDO::PARAM_INT);
            $stAddresses->bindValue("address", $address["address"]);
            $stAddresses->bindValue("postal_code", $address["postalCode"], PDO::PARAM_INT);
            $stAddresses->execute();
        }
        $connection->commit();
    } catch (PDOException $exception) {
        $connection->rollBack();
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") {
            if (str_contains("name", $exception->getMessage()))
                throw new Exception("[name] unique constraint violation");
            if (str_contains("foreign key", $exception->getMessage()))
                throw new ValueError("foreign key constraint violation");
            throw new ValueError("constraint violation");
        }
        throw new Exception("internal server error");
    }
}

function deleteBusiness($business_id): void {
    try {
        $sql = "DELETE FROM businesses WHERE business_id = :business_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $business_id, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new Exception("no row was deleted");
    } catch (PDOException $exception) {
        throw new Exception("internal server error");
    }
}

function getAllBusinessCategories(): array {
    return getConnection()->query("SELECT category_id AS categoryId, name FROM businesses_categories")
        ->fetchAll();
}

function getAllBusinessesByCategory($categoryId): array {
    $sql = "SELECT b.business_id AS businessId, b.name, b.description, b.cover_img AS coverImg 
            FROM businesses b
            INNER JOIN businesses_categories_mapping bcm ON b.business_id = bcm.business_id
            WHERE bcm.category_id = :category_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("category_id", $categoryId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function getAllBusinessAdvertCategories($businessId): array {
    $sql = "SELECT category_id AS categoryId, name FROM businesses_advert_categories 
                                   WHERE business_id = :business_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function persistBusinessAdvertCategory($businessId, $name): void {
    $sql = "INSERT INTO businesses_advert_categories(business_id, name) VALUES(:business_id, :name)";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("name", $name);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new Exception("could not persist record");
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") {
            if (str_contains("foreign key", $exception->getMessage()))
                throw new ValueError("foreign key constraint violation");
            throw new ValueError("constraint violation");
        }
        throw new Exception("internal server error");
    }
}

function deleteBusinessAdvertCategory($categoryId): void {
    $sql = "DELETE FROM businesses_advert_categories WHERE category_id = :category_id";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("category_id", $categoryId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new Exception("no row was deleted");
    } catch (PDOException $exception) {
        throw new Exception("internal server error");
    }
}

function doesAccountOwnBusiness($accountId, $businessId): bool {
    $sql = "SELECT business_id FROM businesses WHERE account_id = :account_id AND business_id = :business_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
    $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->rowCount() > 0;
}