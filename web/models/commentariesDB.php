<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAllArticleCommentaries($articleId, $userAccount): array {
    try {
        $connection = getConnection();

        $sql = "SELECT c.commentary_id commentaryId, article_id articleId, commentator_id commentatorId, 
        title, description, creation_date creationDate, modified_date modifiedDate, 
        COUNT(CASE WHEN is_liked = 1 THEN 1 END) AS likeCount,
        COUNT(CASE WHEN is_liked = 0 THEN 1 END) AS dislikeCount
        FROM commentaries c
        LEFT JOIN commentaries_likes cl ON c.commentary_id = cl.commentary_id
        WHERE article_id = :article_id
        GROUP BY c.commentary_id";
        $sqlCommentariesLikes = "SELECT liker_id likerId, commentary_id commentaryId, is_liked isLiked 
        FROM commentaries_likes WHERE commentary_id = :commentary_id AND liker_id = :account_id";

        $statement = $connection->prepare($sql);
        $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statement->execute();
        $commentaries = $statement->fetchAll();

        $statementCommentariesLikes = $connection->prepare($sqlCommentariesLikes);

        foreach ($commentaries as &$commentary) {
            $statementCommentariesLikes->bindValue("commentary_id", $commentary["commentaryId"],
                PDO::PARAM_INT);
            $statementCommentariesLikes->bindValue("account_id", $userAccount["accountId"], PDO::PARAM_INT);
            $statementCommentariesLikes->execute();
            $record = $statementCommentariesLikes->fetch();
            $commentary["userFeedback"] = !empty($record) ? $record['isLiked'] : null;
        }
        return $commentaries;
    } catch (PDOException $exception) {
        error_log("Database error: [$articleId, $userAccount[accountId] " . $exception->getMessage());
        throw $exception;
    }
}
