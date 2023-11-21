<?php
function getArticle($articleId): array {
    try {
        $sql = "SELECT articles.article_id AS articleId, account_id AS accountId, title, description, created_date creationDate, 
        modified_date modifiedDate, ac.category_id categoryId, ac.name categoryName 
                FROM articles 
                LEFT JOIN articles_categories_mapping acm ON articles.article_id = acm.article_id
                LEFT JOIN article_categories ac ON acm.category_id = ac.category_id
                WHERE articles.article_id = :article_id";
        $sqlCommentaries = "SELECT commentary_id commentaryId, article_id articleId, commentator_id commentatorId,
        title, description, creation_date creationDate, modified_date modifiedDate 
        FROM commentaries WHERE article_id = :article_id";
        $connection = getConnection();

        $statement = $connection->prepare($sql);
        $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("No article found");
        $article = $statement->fetch();

        $statementCommentaries = $connection->prepare($sqlCommentaries);
        $statementCommentaries->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statementCommentaries->execute();
        $article["commentaries"] = $statementCommentaries->fetchAll();

        return $article;
    } catch (PDOException $exception) {
        error_log("Database error: [$articleId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllArticles() :array {
    try {
        $sql = "SELECT article_id AS articleId, account_id AS accountId, title, description, created_date createdDate, 
       modified_date modifiedDate 
                FROM articles";
        $statement = getConnection()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error:" . $exception->getMessage());
        throw $exception;
    }
}

function getArticlesByAccountId($accountId) :array {
    try {
        $sql = "SELECT articles.article_id AS articleId, account_id AS accountId, title, description, 
       created_date AS createdDate, modified_date AS modifiedDate, ac.category_id categoryId, ac.name categoryName
                FROM articles
                LEFT JOIN articles_categories_mapping AS acm ON articles.article_id = acm.article_id
                LEFT JOIN article_categories AS ac ON acm.category_id = ac.category_id
                WHERE account_id = :account_id";
        $connection = getConnection();
        $statement = $connection->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId] " . $exception->getMessage());
        throw $exception;
    }
}

function persistArticle($accountId, $title, $description, $categoryId): void {
    try {
        $sql = "INSERT INTO articles(article_id, account_id, title, description, created_date) 
                VALUES (DEFAULT, :account_id, :title, :description, CURRENT_TIMESTAMP)";

        $connection = getConnection();
        $connection->beginTransaction();

        $statement = $connection->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("title", $title);
        $statement->bindValue("description", $description);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not persist article");

        $articlePrimaryKey = $connection->lastInsertId();

        if (!empty($categoryId)) {
            $sqlCategories = "INSERT INTO articles_categories_mapping(article_id, category_id) 
                              VALUES(:article_id, :category_id)";
            $statementCategories = $connection->prepare($sqlCategories);
            $statementCategories->bindValue("article_id", $articlePrimaryKey, PDO::PARAM_INT);
            $statementCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
            $statementCategories->execute();
        }

        $connection->commit();
    } catch (PDOException $exception) {
        echo $exception->getMessage();
        error_log("Database error: [$accountId, $title] " . $exception->getMessage());
        throw $exception;
    }
}

function updateArticle($articleId, $title, $description, $categoryId): void {
    $sql = "UPDATE articles SET title = :title, description = :description, modified_date = NOW()
                WHERE article_id = :article_id";
    $connection = getConnection();
    $statement = $connection->prepare($sql);
    $statement->bindValue("title", $title);
    $statement->bindValue("description", $description);
    $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
    $statement->execute();

    $sqlUpdateCategory = "UPDATE articles_categories_mapping SET category_id = :category_id 
                                   WHERE article_id = :article_id";
    $statement = $connection->prepare($sqlUpdateCategory);
    $statement->bindValue("category_id", $categoryId);
    $statement->bindValue("article_id", $articleId);
    $statement->execute();
}

function deleteArticle($accountId, $articleId) :void {
    try {
        $sql = "DELETE FROM articles WHERE account_id = :account_id AND article_id = :article_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not delete article");
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId, $articleId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllArticlesCategories(): array {
    try {
        $sql = "SELECT category_id as categoryId, name FROM article_categories";
        $statement = getConnection()->query($sql);
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        throw $exception;
    }
}
