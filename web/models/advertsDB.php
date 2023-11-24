<?php
function getAdvert($advertId): array {
    try {
        $sqlAdverts = "SELECT advert_id AS advertId, business_id AS businessId, title, description, 
        cover_img AS coverImg, active, creation_date AS creationDate, modified_date AS modifiedDate FROM adverts 
        WHERE advert_id = :advert_id";
        $sqlImages = "SELECT image_id AS imageId, advert_id AS advertId, url FROM images WHERE advert_id = :advert_id";
        $sqlCharacteristics = "SELECT characteristic_id AS characteristicId, advert_id AS advertId, type, value 
        FROM adverts_characteristics WHERE advert_id = :advert_id";
        $sqlCategories = "SELECT category_id AS categoryId, name FROM businesses_advert_categories WHERE category_id IN 
                                            (SELECT category_id FROM advert_categories WHERE advert_id = :advert_id)";

        $connection = getConnection();
        $stAdverts = $connection->prepare($sqlAdverts);
        $stImages = $connection->prepare($sqlImages);
        $stCharacteristics = $connection->prepare($sqlCharacteristics);
        $stCategories = $connection->prepare($sqlCategories);

        $stAdverts->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $stAdverts->execute();
        if ($stAdverts->rowCount() === 0) throw new PDOException("No advert found");
        $advert = $stAdverts->fetch();

        $stImages->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $stImages->execute();
        $advert["images"] = $stImages->fetchAll();

        $stCharacteristics->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $stCharacteristics->execute();
        $advert["characteristics"] = $stCharacteristics->fetchAll();

        $stCategories->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $stCategories->execute();
        $advert["categories"] = $stCategories->fetchAll();
        return $advert;
    } catch (PDOException $exception) {
        throw new Exception("No advert found");
    }
}

function getAllAdverts(): array {
    $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img AS coverImg, 
    active, creation_date AS creationDate, modified_date AS modifiedDate FROM adverts";
    $statement = getConnection()->query($sql);
    return $statement->fetchAll();
}

function getAdvertsByBusinessId($businessId): array {
    $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img AS coverImg, 
    active, creation_date AS creationDate, modified_date AS modifiedDate FROM adverts 
    WHERE business_id = :business_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function persistAdvert($businessId, $title, $description, $coverImg, $active, $categoryId,
                       array $characteristics, array $images): void {
    $sqlAdvert = "INSERT INTO adverts(advert_id, business_id, title, description, cover_img, active, creation_date) 
                VALUES (DEFAULT, :business_id, :title, :description, :cover_img, :active, CURRENT_TIMESTAMP)";
    $sqlCharacteristics = "INSERT INTO adverts_characteristics(advert_id, type, value) 
                                   VALUES(:advert_id, :type, :value)";
    $sqlCategories = "INSERT INTO advert_categories(advert_id, category_id) VALUES(:advert_id, :category_id)";
    $sqlImages = "INSERT INTO images(advert_id, url) VALUES(:advert_id, :url)";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $stAdvert = $connection->prepare($sqlAdvert);
        $stCharacteristics = $connection->prepare($sqlCharacteristics);
        $stCategories = $connection->prepare($sqlCategories);
        $stImages = $connection->prepare($sqlImages);

        $stAdvert->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $stAdvert->bindValue("title", $title);
        $stAdvert->bindValue("description", $description);
        $stAdvert->bindValue("cover_img", $coverImg ?? null);
        $stAdvert->bindValue("active", $active, PDO::PARAM_INT);
        $stAdvert->execute();

        $advertPrimaryKey = $connection->lastInsertId();

        foreach ($characteristics as $characteristic) {
            $stCharacteristics->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
            $stCharacteristics->bindValue("type", $characteristic["type"]);
            $stCharacteristics->bindValue("value", $characteristic["value"]);
            $stCharacteristics->execute();
        }

        if (isset($categoryId)) {
            $stCategories->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
            $stCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
            $stCategories->execute();
        }

        foreach ($images as $image) {
            $stImages->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
            $stImages->bindValue("url", $image);
            $stImages->execute();
        }

        $connection->commit();
    } catch (PDOException $exception) {
        $connection->rollBack();
        throw new Exception("Could not persist advert");
    }
}

function updateAdvert($advertId, $title, $description, $coverImg, $categoryId, array $characteristics,
                      array $images, array $imagesToDelete): void {
    $sqlAdverts = "UPDATE adverts SET title = :title, description = :description, cover_img = :cover_img, modified_date = NOW()
               WHERE advert_id = :advert_id";
    $sqlDeleteCategory = "DELETE FROM advert_categories WHERE advert_id = :advert_id";
    $sqlCategories = "INSERT INTO advert_categories(advert_id, category_id) VALUES(:advert_id, :category_id)";
    $sqlCharacteristicsDelete = "DELETE FROM adverts_characteristics WHERE advert_id = :advert_id";
    $sqlCharacteristics = "INSERT INTO adverts_characteristics(advert_id, type, value) 
                                   VALUES(:advert_id, :type, :value)";
    $sqlImages = "INSERT INTO images(advert_id, url) VALUES(:advert_id, :url)";
    $placeholders = implode(',', array_fill(0, count($imagesToDelete), '?'));
    $sqlDeleteImages = "DELETE FROM images WHERE image_id IN ({$placeholders})";

    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $stAdvert = $connection->prepare($sqlAdverts);
        $stCategoryDelete = $connection->prepare($sqlDeleteCategory);
        $stCategories = $connection->prepare($sqlCategories);
        $stCharacteristicsDelete = $connection->prepare($sqlCharacteristicsDelete);
        $stCharacteristics = $connection->prepare($sqlCharacteristics);
        $stDeleteImages = $connection->prepare($sqlDeleteImages);
        $stImages = $connection->prepare($sqlImages);

        $stAdvert->bindValue("title", $title);
        $stAdvert->bindValue("description", $description);
        $stAdvert->bindValue("cover_img", $coverImg);
        $stAdvert->bindValue("advert_id", $advertId);
        $stAdvert->execute();

        $stCategoryDelete->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $stCategoryDelete->execute();

        if (!empty($categoryId)) {
            $stCategories->bindValue("advert_id", $advertId, PDO::PARAM_INT);
            $stCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
            $stCategories->execute();
        }

        $stCharacteristicsDelete->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $stCharacteristicsDelete->execute();

        foreach ($characteristics as $characteristic) {
            $stCharacteristics->bindValue("advert_id", $advertId, PDO::PARAM_INT);
            $stCharacteristics->bindValue("type", $characteristic["type"]);
            $stCharacteristics->bindValue("value", $characteristic["value"]);
            $stCharacteristics->execute();
        }

        if (!empty($imagesToDelete)) {
            foreach ($imagesToDelete as $index => $value)
                $stDeleteImages->bindValue(($index + 1), $value);
            $stDeleteImages->execute();
        }

        foreach ($images as $image) {
            $stImages->bindValue("advert_id", $advertId, PDO::PARAM_INT);
            $stImages->bindValue("url", $image);
            $stImages->execute();
        }
        $connection->commit();
    } catch (PDOException $exception) {
        $connection->rollBack();
        throw new Exception("Could not persist advert");
    }
}

function deleteAdvert($advertId): void {
    try {
        $sql = "DELETE FROM adverts WHERE advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not delete advert");
    } catch (PDOException $exception) {
        throw new Exception("Could not delete advert");
    }
}

function getAdvertCharacteristics($advertId): array {
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

function getAdvertCategories($advertId): array {
    $sql = "SELECT ad.category_id categoryId, name 
    FROM advert_categories ad INNER JOIN businesses_advert_categories bac ON ad.category_id = bac.category_id 
    WHERE advert_id = :advert_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
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

function getAdvertImages($advertId): array {
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
