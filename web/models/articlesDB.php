<?php
function getArticle($articleId) {
    try {
        $sql = "SELECT article_id AS articleId, account_id AS accountId, title, description, created_date, modified_date 
                FROM articles 
                WHERE article_id = :article_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("No article found");
        return $statement->fetchAll()[0];

    } catch (PDOException $exception) {
        error_log("Database error: [$articleId] " . $exception->getMessage());
        throw $exception;
    }
}

function getAllArticles() :array {
    try {
        $sql = "SELECT article_id AS articleId, account_id AS accountId, title, description, created_date, modified_date 
                FROM articles";
        $statement = getConnection()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error:" . $exception->getMessage());
        throw $exception;
    }
}

function getArticleByAccountId($accountId) :array {
    try {
        $sql = "SELECT article_id AS articleId, account_id AS accountId, title, description, created_date, modified_date 
                FROM articles 
                WHERE account_id = :account_id";
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: [$accountId] " . $exception->getMessage());
        throw $exception;
    }
}

function persistArticle($accountId, $title, $description, $categoryIds) :void {
    try {
        $sql = "INSERT INTO articles(article_id, account_id, title, description, created_date) 
                VALUES (DEFAULT, :account_id, :title, :description, CURRENT_TIMESTAMP)";

        $connection = getConnection();
        $connection->beginTransaction();

        $statement = $connection->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("title", $title, PDO::PARAM_STR);
        $statement->bindValue("description", $description, PDO::PARAM_STR);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not persist article");

        $articlePrimaryKey = $connection->lastInsertId();

        if (!empty($categoryIds)) {
            $sqlCategories = "INSERT INTO articles_categories_mapping(article_id, category_id) 
                              VALUES(:article_id, :category_id)";
            $statementCategories = $connection->prepare($sqlCategories);
            foreach ($categoryIds as $categoryId) {
                $statementCategories->bindValue("article_id", $articlePrimaryKey, PDO::PARAM_INT);
                $statementCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
                $statementCategories->execute();
            }
        }

        $connection->commit();
    } catch (PDOException $exception) {
        echo $exception->getMessage();
        error_log("Database error: [$accountId, $title] " . $exception->getMessage());
        throw $exception;
    }
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
