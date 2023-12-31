<?php
function getArticle($articleId): array {
    $sql = "SELECT articles.article_id articleId, account_id accountId, title, description, 
                        DATE(created_date) creationDate, DATE(modified_date) modifiedDate, 
                        ac.category_id categoryId, ac.name categoryName 
    FROM articles LEFT JOIN articles_categories_mapping acm ON articles.article_id = acm.article_id
    LEFT JOIN article_categories ac ON acm.category_id = ac.category_id WHERE articles.article_id = :article_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() === 0) throw new ("no record was found");
    return $statement->fetch();
}

function getAllArticles(): array {
    $sql = "SELECT a.article_id articleId, account_id accountId, title, description, ac.name categoryName, 
       ac.category_id categoryId, DATE(created_date) createdDate, DATE(modified_date) modifiedDate 
    FROM articles a LEFT JOIN articles_categories_mapping acm ON a.article_id = acm.article_id
    LEFT JOIN article_categories ac ON acm.category_id = ac.category_id";
    return getConnection()->query($sql)->fetchAll();
}

function getArticlesByAccountId($accountId) :array {
    $sql = "SELECT articles.article_id articleId, account_id accountId, title, description, 
    created_date createdDate, modified_date modifiedDate, ac.category_id categoryId, ac.name categoryName
    FROM articles LEFT JOIN articles_categories_mapping AS acm ON articles.article_id = acm.article_id
    LEFT JOIN article_categories AS ac ON acm.category_id = ac.category_id
    WHERE account_id = :account_id";
    $connection = getConnection();
    $statement = $connection->prepare($sql);
    $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function persistArticle($accountId, $title, $description, $categoryId): void {
    $sql = "INSERT INTO articles(article_id, account_id, title, description, created_date) 
                VALUES (DEFAULT, :account_id, :title, :description, CURRENT_TIMESTAMP)";
    $sqlCategories = "INSERT INTO articles_categories_mapping(article_id, category_id) 
                              VALUES(:article_id, :category_id)";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $stArticles = $connection->prepare($sql);
        $stCategories = $connection->prepare($sqlCategories);

        $stArticles->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $stArticles->bindValue("title", $title);
        $stArticles->bindValue("description", $description);
        $stArticles->execute();
        $articleId = $connection->lastInsertId();

        if (!empty($categoryId)) {
            $stCategories->bindValue("article_id", $articleId, PDO::PARAM_INT);
            $stCategories->bindValue("category_id", $categoryId, PDO::PARAM_INT);
            $stCategories->execute();
        }

        $connection->commit();
    } catch (PDOException $exception) {
        $connection->rollBack();
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") throw new ValueError("constraint violation");
        throw new Exception("internal server error");
    }
}

function updateArticle($articleId, $title, $description, $categoryId): void {
    $sql = "UPDATE articles SET title = :title, description = :description, modified_date = NOW()
                WHERE article_id = :article_id";
    $sqlUpdateCategory = "UPDATE articles_categories_mapping SET category_id = :category_id 
                                   WHERE article_id = :article_id";
    $connection = getConnection();
    try {
        $connection->beginTransaction();
        $stArticle = $connection->prepare($sql);
        $stCategory = $connection->prepare($sqlUpdateCategory);

        $stArticle->bindValue("title", $title);
        $stArticle->bindValue("description", $description);
        $stArticle->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $stArticle->execute();

        $stCategory->bindValue("category_id", $categoryId);
        $stCategory->bindValue("article_id", $articleId);
        $stCategory->execute();
        $connection->commit();
    } catch (PDOException $exception) {
        $connection->rollBack();
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") throw new ValueError("constraint violation");
        throw new Exception("internal server error");
    }
}

function deleteArticle($articleId): void {
    $sql = "DELETE FROM articles WHERE article_id = :article_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() === 0) throw new Exception("no row was deleted");
}

function getAllArticlesCategories(): array {
    return getConnection()->query("SELECT category_id as categoryId, name FROM article_categories")->fetchAll();
}

function getAllArticlesByCategory($categoryId): array {
    $sql = "SELECT articles.article_id AS articleId, articles.account_id AS accountId, 
                    title, description, DATE(created_date) AS createdDate, 
                    DATE(modified_date) AS modifiedDate, 
                    ac.category_id AS categoryId, ac.name AS categoryName 
            FROM articles 
            LEFT JOIN articles_categories_mapping acm ON articles.article_id = acm.article_id
            LEFT JOIN article_categories ac ON acm.category_id = ac.category_id
            WHERE ac.category_id = :category_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("category_id", $categoryId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function persistArticleCategory($name): void {
    $sql = "INSERT INTO article_categories(category_id, name) VALUES (DEFAULT, :name)";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("name", $name);
        $statement->execute();
    } catch (PDOException $exception) {
        if ($exception->getCode() === "22001") throw new ValueError("invalid parameter");
        if ($exception->getCode() === "23000") throw new ValueError("constraint violation");
        throw new Exception("internal server error");
    }
}

function deleteArticleCategory($categoryId): void {
    $sql = "DELETE FROM article_categories WHERE category_id = :category_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("category_id", $categoryId, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() === 0) throw new Exception("no row was affected");
}

function doesAccountOwnArticle($accountId, $articleId): bool {
    $sql = "SELECT COUNT(article_id) FROM articles WHERE account_id = :account_id AND article_id = :article_id";
    $statement = getConnection()->prepare($sql);
    $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
    $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
    $statement->execute();
    return $statement->rowCount() > 0;
}

