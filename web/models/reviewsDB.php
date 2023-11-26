<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAllReviews(): array {
    $sql = "SELECT review_id reviewId, account_id accountId, business_id businessId, title, description, 
       creation_date creationDate, modified_date modifiedDate, rating FROM reviews";
    return getConnection()->query($sql)->fetchAll();
}

function getAllBusinessReviews($businessId, $accountId): array {
    $sqlReviews = "SELECT r.review_id reviewId, ac.account_id accountId, ac.username, 
    business_id businessId, title, description, r.creation_date creationDate, modified_date modifiedDate, rating,
    COUNT(CASE WHEN is_liked = 1 THEN 1 END) likeCount, COUNT(CASE WHEN is_liked = 0 THEN 1 END) dislikeCount
    FROM reviews r
    INNER JOIN accounts ac ON r.account_id = ac.account_id 
    LEFT JOIN reviews_likes rl ON r.review_id = rl.review_id WHERE business_id = :business_id
    GROUP BY r.review_id";
    $sqlReviewsLike = "SELECT is_liked liked FROM reviews_likes WHERE review_id = :review_id 
                       AND commentator_id = :account_id";
    $connection = getConnection();
    $stReviews = $connection->prepare($sqlReviews);
    $stReviewsLike = $connection->prepare($sqlReviewsLike);

    $stReviews->bindValue("business_id", $businessId, PDO::PARAM_INT);
    $stReviews->execute();
    $reviews = $stReviews->fetchAll();

    if (!empty($accountId))
        foreach ($reviews as &$review) {
            $stReviewsLike->bindValue("review_id", $review["reviewId"], PDO::PARAM_INT);
            $stReviewsLike->bindValue("account_id", $accountId, PDO::PARAM_INT);
            $stReviewsLike->execute();
            $record = $stReviewsLike->fetch();
            $review["userFeedback"] = !empty($record) ? $record['liked'] : null;
        }
    return $reviews;
}

function persistBusinessReview($businessId, $accountId, $title, $description, $rating): void {
    $sql = "INSERT INTO reviews(account_id, business_id, title, description, rating) 
        VALUES(:account_id, :business_id, :title, :description, :rating)";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("business_id", $businessId, PDO::PARAM_INT);
        $statement->bindValue("title", $title);
        $statement->bindValue("description", $description);
        $statement->bindValue("rating", $rating);
        $statement->execute();
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") throw new ValueError("constraint violation");
        throw new Exception("internal server error");
    }
}

function persistReviewLike($userAccount, $reviewId, $isLiked): void {
    $sql = "INSERT INTO reviews_likes(commentator_id, review_id, is_liked) 
        VALUES(:commentator_id, :review_id, :is_liked)";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("commentator_id", $userAccount["accountId"], PDO::PARAM_INT);
        $statement->bindValue("review_id", $reviewId, PDO::PARAM_INT);
        $statement->bindValue("is_liked", $isLiked, PDO::PARAM_BOOL);
        $statement->execute();
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") throw new ValueError("constraint violation");
        throw new Exception("internal server error");
    }
}

function updateReviewLike($userAccount, $reviewId, $isLiked): void {
    try {
        $sql = "UPDATE reviews_likes SET is_liked = :is_liked 
                     WHERE review_id = :review_id AND commentator_id = :account_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("is_liked", $isLiked, PDO::PARAM_BOOL);
        $statement->bindValue("review_id", $reviewId, PDO::PARAM_INT);
        $statement->bindValue("account_id", $userAccount["accountId"], PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") throw new ValueError("constraint violation");
        throw new Exception("internal server error");
    }
}

function deleteReview($reviewId): void {
    $sql = "DELETE FROM reviews WHERE review_id = :review_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("review_id", $reviewId, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() === 0) throw new Exception("no row was affected");
}

function deleteReviewLike($userAccount, $reviewId): void {
    try {
        $sql = "DELETE FROM reviews_likes WHERE review_id = :review_id AND commentator_id = :account_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("review_id", $reviewId, PDO::PARAM_INT);
        $statement->bindValue("account_id", $userAccount["accountId"], PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception) {
        throw new Exception("Could not delete review like");
    }
}
