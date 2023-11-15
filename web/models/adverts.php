<?php
function getAdvert($advertId) {
    try {
        $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img, active, creation_date, modified_date
                FROM adverts 
                WHERE advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        if ($statement->rowCount() === 0) throw new PDOException("No advert found");
        return $statement->fetchAll()[0];
    } catch (PDOException $exception) {
        error_log("Database error: [$advertId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllAdverts() :array {
    try {
        $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img, active, creation_date, modified_date
                FROM adverts";
        $statement = getConnection()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error:" . $exception->getMessage());
        throw $exception;
    }
}

function getAdvertByBusinessId($businessId) :array {
    try {
        $sql = "SELECT advert_id AS advertId, business_id AS businessId, title, description, cover_img, active, creation_date, modified_date
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

function persistAdvert($businessId, $title, $description, $coverImg, $active, $characteristics, $categories, $images) :void {
    try {
        $sql = "INSERT INTO adverts(advert_id, business_id, title, description, cover_img, active, creation_date) 
                VALUES (DEFAULT, :business_id, :title, :description, :cover_img, :active, CURRENT_TIMESTAMP)";

        $connection = getConnection();
        $connection->beginTransaction();

        $statement = $connection->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("title", $title, PDO::PARAM_STR);
        $statement->bindValue("description", $description, PDO::PARAM_STR);
        $statement->bindValue("cover_img", $coverImg, PDO::PARAM_STR);
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
                $statementCharacteristics->bindValue("type", $characteristic["type"], PDO::PARAM_STR);
                $statementCharacteristics->bindValue("value", $characteristic["value"], PDO::PARAM_STR);
                $statementCharacteristics->execute();
            }
        }

        if (!empty($categories)) {
            $sqlCategories = "INSERT INTO advert_categories(advert_id, category_id) 
                              VALUES(:advert_id, :category_id)";
            $statementCategories = $connection->prepare($sqlCategories);
            foreach ($categories as $categoryId) {
                $statementCategories->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
                $statementCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
                $statementCategories->execute();
            }
        }

        if (!empty($images)) {
            $sqlImages = "INSERT INTO images(advert_id, url) 
                          VALUES(:advert_id, :url)";
            $statementImages = $connection->prepare($sqlImages);
            foreach ($images as $image) {
                $statementImages->bindValue("advert_id", $advertPrimaryKey, PDO::PARAM_INT);
                $statementImages->bindValue("url", $image["url"], PDO::PARAM_STR);
                $statementImages->execute();
            }
        }

        $connection->commit();
    } catch (PDOException $exception) {
        echo $exception->getMessage();
        error_log("Database error: [$businessId, $title] " . $exception->getMessage());
        throw $exception;
    }
}

function deleteAdvert($businessId, $advertId) :void {
    try {
        $sql = "DELETE FROM adverts WHERE business_id = :business_id AND advert_id = :advert_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("advert_id", $advertId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not delete advert");
    } catch (PDOException $exception) {
        error_log("Database error: [$businessId, $advertId] " . $exception->getMessage());
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
