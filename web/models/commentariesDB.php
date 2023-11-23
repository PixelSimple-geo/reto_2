<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAllArticleCommentaries($articleId, $userAccount): array {
    $sqlCommentaries = "SELECT c.commentary_id commentaryId, article_id articleId, commentator_id commentatorId, 
        title, description, creation_date creationDate, modified_date modifiedDate, 
        COUNT(CASE WHEN is_liked = 1 THEN 1 END) likeCount, COUNT(CASE WHEN is_liked = 0 THEN 1 END) dislikeCount
        FROM commentaries c LEFT JOIN commentaries_likes cl ON c.commentary_id = cl.commentary_id
        WHERE article_id = :article_id GROUP BY c.commentary_id";
    $sqlCommentariesLikes = "SELECT is_liked isLiked FROM commentaries_likes 
                        WHERE commentary_id = :commentary_id AND liker_id = :account_id";
    $connection = getConnection();

    $stCommentaries = $connection->prepare($sqlCommentaries);
    $stCommentariesLikes = $connection->prepare($sqlCommentariesLikes);

    $stCommentaries->bindValue("article_id", $articleId, PDO::PARAM_INT);
    $stCommentaries->execute();
    $commentaries = $stCommentaries->fetchAll();

    foreach ($commentaries as &$commentary) {
        $stCommentariesLikes->bindValue("commentary_id", $commentary["commentaryId"],
            PDO::PARAM_INT);
        $stCommentariesLikes->bindValue("account_id", $userAccount["accountId"], PDO::PARAM_INT);
        $stCommentariesLikes->execute();
        $record = $stCommentariesLikes->fetch();
        $commentary["userFeedback"] = !empty($record) ? $record['isLiked'] : null;
    }
    return $commentaries;
}

function persistCommentary($commentatorId, $articleId, $title, $description): void {
    $sql = "INSERT INTO commentaries(article_id, commentator_id, title, description) 
    VALUES(:article_id, :commentator_id, :title, :description)";
    $connection = getConnection();
    try {
        $statement = $connection->prepare($sql);
        $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statement->bindValue("commentator_id", $commentatorId, PDO::PARAM_INT);
        $statement->bindValue("title", $title);
        $statement->bindValue("description", $description);
        $statement->execute();
    } catch (PDOException $exception) {
        error_log("Database error: [$commentatorId, $articleId, $title, $description "
            . $exception->getMessage());
        throw $exception;
    }
}

function persistCommentaryLike($likerId, $commentaryId, $isLiked): void {
    $sql = "INSERT INTO commentaries_likes(liker_id, commentary_id, is_liked) 
    VALUES(:liker_id, :commentary_id, :is_liked)";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $statement = $connection->prepare($sql);
        $statement->bindValue("liker_id", $likerId, PDO::PARAM_INT);
        $statement->bindValue("commentary_id", $commentaryId, PDO::PARAM_INT);
        $statement->bindValue("is_liked", $isLiked, PDO::PARAM_BOOL);
        $statement->execute();
    } catch (PDOException $exception) {
        $connection->rollBack();
        throw new Exception("Could not persist commentary like");
    }
}

function updateCommentaryLike($likerId, $commentaryId, $isLiked): void {
    $sql = "UPDATE commentaries_likes SET is_liked = :is_liked 
                          WHERE liker_id = :liker_id AND commentary_id = :commentary_id";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $statement = $connection->prepare($sql);
        $statement->bindValue("is_liked", $isLiked, PDO::PARAM_BOOL);
        $statement->bindValue("liker_id", $likerId, PDO::PARAM_INT);
        $statement->bindValue("commentary_id", $commentaryId, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception) {
        $connection->rollBack();
        throw new Exception("Could not update commentary like");
    }
}

function deleteCommentaryLike($likerId, $commentaryId): void {
    $sql = "DELETE FROM commentaries_likes WHERE liker_id = :liker_id AND commentary_id = :commentary_id";
    $connection = getConnection();
    try {
        $statement = $connection->prepare($sql);
        $statement->bindValue("liker_id", $likerId, PDO::PARAM_INT);
        $statement->bindValue("commentary_id", $commentaryId, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception) {
        throw new Exception("Could not delete commentary like");
    }
}