<?php
function getAdvert($advertId): array {
    try {
        $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img AS coverImg, 
       active, creation_date AS creationDate, modified_date AS modifiedDate 
        FROM adverts 
        WHERE advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("No advert found");
        $advert = $statement->fetchAll()[0];

        $sqlImages = "SELECT image_id AS imageId, advert_id AS advertId, url FROM images WHERE advert_id = :advert_id";
        $statementImages = getConnection()->prepare($sqlImages);
        $statementImages->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statementImages->execute();
        if ($statementImages->rowCount() > 0)
            $advert["images"] = $statementImages->fetchAll();

        $sqlCharacteristics = "SELECT characteristic_id AS characteristicId, advert_id AS advertId, type, value 
        FROM adverts_characteristics WHERE advert_id = :advert_id";
        $statementCharacteristics = getConnection()->prepare($sqlCharacteristics);
        $statementCharacteristics->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statementCharacteristics->execute();
        if ($statementCharacteristics->rowCount() > 0)
            $advert["characteristics"] = $statementCharacteristics->fetchAll();

        $sqlCategories = "SELECT category_id AS categoryId, name FROM businesses_advert_categories WHERE category_id IN 
                                            (SELECT category_id FROM advert_categories WHERE advert_id = :advert_id)";
        $statementCategories = getConnection()->prepare($sqlCategories);
        $statementCategories->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statementCategories->execute();
        $advert["categories"] = $statementCategories->fetchAll();
        return $advert;
    } catch (PDOException $exception) {
        error_log("Database error: [$advertId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllAdverts(): array {
    try {
        $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img AS coverImg, 
       active, creation_date AS creationDate, modified_date AS modifiedDate 
        FROM adverts";
        $statement = getConnection()->query($sql);
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error:" . $exception->getMessage());
        throw $exception;
    }
}

function getAdvertsByBusinessId($businessId): array {
    try {
        $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img AS coverImg, 
       active, creation_date AS creationDate, modified_date AS modifiedDate 
                FROM adverts
                WHERE business_id = :business_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$businessId] " . $exception->getMessage());
        throw $exception;
    }
}

function persistAdvert($businessId, $title, $description, $coverImg, $active, $categoryId,
                       array $characteristics, array $images): void {
    try {
        $sql = "INSERT INTO adverts(advert_id, business_id, title, description, cover_img, active, creation_date) 
                VALUES (DEFAULT, :business_id, :title, :description, :cover_img, :active, CURRENT_TIMESTAMP)";
        $connection = getConnection();
        $connection->beginTransaction();

        $statement = $connection->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("title", $title);
        $statement->bindValue("description", $description);
        if (isset($coverImg))
            $statement->bindValue("cover_img", $coverImg);
        else $statement->bindValue("cover_img", null);
        $statement->bindValue("active", $active, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not persist advert");

        $advertPrimaryKey = $connection->lastInsertId();

        if (!empty($characteristics)) {
            $sqlCharacteristics = "INSERT INTO adverts_characteristics(advert_id, type, value) 
                                   VALUES(:advert_id, :type, :value)";
            $statementCharacteristics = $connection->prepare($sqlCharacteristics);
            foreach ($characteristics as $characteristic) {
                $statementCharacteristics->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
                $statementCharacteristics->bindValue("type", $characteristic["type"]);
                $statementCharacteristics->bindValue("value", $characteristic["value"]);
                $statementCharacteristics->execute();
            }
        }

        if (isset($categoryId)) {
            $sqlCategories = "INSERT INTO advert_categories(advert_id, category_id) VALUES(:advert_id, :category_id)";
            $statementCategories = $connection->prepare($sqlCategories);
            $statementCategories->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
            $statementCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
            $statementCategories->execute();
        }

        if (!empty($images)) {
            $sqlImages = "INSERT INTO images(advert_id, url) VALUES(:advert_id, :url)";
            $statementImages = $connection->prepare($sqlImages);
            foreach ($images as $index => $image) {
                $statementImages->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
                $statementImages->bindValue("url", $image);
                $statementImages->execute();
            }
        }

        $connection->commit();
    } catch (PDOException $exception) {
        error_log("Database error: [$businessId, $title] " . $exception->getMessage());
        throw $exception;
    }
}

function updateAdvert($advertId, $title, $description, $coverImg, $categoryId, array $characteristics,
                      array $images, array $imagesToDelete) {
    $sql = "UPDATE adverts SET title = :title, description = :description, cover_img = :cover_img, modified_date = NOW()
               WHERE advert_id = :advert_id";

    $connection = getConnection();
    $statement = $connection->prepare($sql);
    $statement->bindValue("title", $title);
    $statement->bindValue("description", $description);
    $statement->bindValue("cover_img", $coverImg);
    $statement->bindValue("advert_id", $advertId);
    $statement->execute();

    $sqlDeleteCategory = "DELETE FROM advert_categories WHERE advert_id = :advert_id";
    $statementCategoryDelete = $connection->prepare($sqlDeleteCategory);
    $statementCategoryDelete->bindValue("advert_id", $advertId, PDO::PARAM_INT);
    $statementCategoryDelete->execute();

    if (!empty($categoryId)) {
        $sqlCategories = "INSERT INTO advert_categories(advert_id, category_id) VALUES(:advert_id, :category_id)";
        $statementCategories = $connection->prepare($sqlCategories);
        $statementCategories->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statementCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
        $statementCategories->execute();
    }

    $sqlCharacteristicsDelete = "DELETE FROM adverts_characteristics WHERE advert_id = :advert_id";
    $statementCharacteristicsDelete = $connection->prepare($sqlCharacteristicsDelete);
    $statementCharacteristicsDelete->bindValue("advert_id", $advertId, PDO::PARAM_INT);
    $statementCharacteristicsDelete->execute();

    if (!empty($characteristics)) {
        $sqlCharacteristics = "INSERT INTO adverts_characteristics(advert_id, type, value) 
                                   VALUES(:advert_id, :type, :value)";
        $statementCharacteristics = $connection->prepare($sqlCharacteristics);
        foreach ($characteristics as $characteristic) {
            $statementCharacteristics->bindValue("advert_id", $advertId, PDO::PARAM_INT);
            $statementCharacteristics->bindValue("type", $characteristic["type"]);
            $statementCharacteristics->bindValue("value", $characteristic["value"]);
            $statementCharacteristics->execute();
        }
    }

    if (!empty($imagesToDelete)) {
        $placeholders = implode(',', array_fill(0, count($imagesToDelete), '?'));
        $sqlDeleteImages = "DELETE FROM images WHERE image_id IN ({$placeholders})";
        $statementDeleteImages = $connection->prepare($sqlDeleteImages);
        foreach ($imagesToDelete as $index => $value)
            $statementDeleteImages->bindValue(($index + 1), $value);
        $statementDeleteImages->execute();
    }

    if (!empty($images)) {
        $sqlImages = "INSERT INTO images(advert_id, url) VALUES(:advert_id, :url)";
        $statementImages = $connection->prepare($sqlImages);
        foreach ($images as $index => $image) {
            $statementImages->bindValue("advert_id", $advertId, PDO::PARAM_INT);
            $statementImages->bindValue("url", $image);
            $statementImages->execute();
        }
    }

}

function deleteAdvert($advertId) :void {
    try {
        $sql = "DELETE FROM adverts WHERE advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not delete advert");
    } catch (PDOException $exception) {
        error_log("Database error: [$advertId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAdvertCharacteristics($advertId) :array {
    try {
        $sql = "SELECT characteristic_id, advert_id, type, value
                FROM adverts_characteristics
                WHERE advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$advertId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAdvertCategories($advertId) :array {
    try {
        $sql = "SELECT category_id
                FROM advert_categories
                WHERE advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $exception) {
        error_log("Database error: [$advertId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllAdvertCategories() :array {
    try {
        $sql = "SELECT * FROM businesses_advert_categories";
        $statement = getConnection()->query($sql);
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        throw $exception;
    }
}

function getAdvertImages($advertId) :array {
    try {
        $sql = "SELECT image_id, advert_id, url
                FROM images
                WHERE advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$advertId] " . $exception->getMessage());
        throw $exception;
    }
}
