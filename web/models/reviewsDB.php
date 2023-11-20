<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAllBusinessReviews($businessId): array {
    try {
        $sql = "SELECT r.review_id reviewId, account_id accountId, business_id businessId, title, description, 
        creation_date creationDate, modified_date modifiedDate, rating, 
        COUNT(CASE WHEN rl.is_liked = 1 THEN 1 END) AS likeCount,
        COUNT(CASE WHEN rl.is_liked = 0 THEN 1 END) AS dislikeCount 
        FROM reviews r
            LEFT JOIN reviews_likes rl ON r.review_id = rl.review_id
        WHERE business_id = :business_id GROUP BY r.review_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$businessId] " . $exception->getMessage());
        throw $exception;
    }
}

function persistBusinessReview($businessId, $accountId, $title, $description, $rating): void {
    try {
        $sql = "INSERT INTO reviews(account_id, business_id, title, description, rating) 
        VALUES(:account_id, :business_id, :title, :description, :rating)";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("title", $title);
        $statement->bindValue("description", $description);
        $statement->bindValue("rating", $rating);
        $statement->execute();
    } catch (PDOException $exception) {
        error_log("Database error: [$businessId] " . $exception->getMessage());
        throw $exception;
    }
}

function persistReviewLike($accountId, $reviewId, $isLiked): void {
    try {
        $sql = "INSERT INTO reviews_likes(commentator_id, review_id, is_liked) 
        VALUES(:commentator_id, :review_id, :is_liked)";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("commentator_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("review_id", $reviewId, PDO::PARAM_INT);
        $statement->bindValue("is_liked", $isLiked, PDO::PARAM_BOOL);
        $statement->execute();
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId, $reviewId, $isLiked] " . $exception->getMessage());
        throw $exception;
    }
}
