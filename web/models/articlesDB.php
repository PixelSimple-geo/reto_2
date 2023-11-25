<?php
function getArticle($articleId): array {
    $sql = "SELECT articles.article_id articleId, account_id accountId, title, description, 
                        DATE(created_date) creationDate, DATE(modified_date) modifiedDate, 
                        ac.category_id categoryId, ac.name categoryName 
                FROM articles 
                LEFT JOIN articles_categories_mapping acm ON articles.article_id = acm.article_id
                LEFT JOIN article_categories ac ON acm.category_id = ac.category_id
                WHERE articles.article_id = :article_id";
    try {
        $connection = getConnection();
        $statement = $connection->prepare($sql);
        $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("No article found");
        return $statement->fetch();
    } catch (PDOException $exception) {
        throw new Exception("No article found");
    }
}

function getAllArticles(): array {
    $sql = "SELECT a.article_id articleId, account_id accountId, title, description, ac.name categoryName, 
       ac.category_id categoryId, DATE(created_date) createdDate, DATE(modified_date) modifiedDate 
    FROM articles a INNER JOIN articles_categories_mapping acm ON a.article_id = acm.article_id
    INNER JOIN article_categories ac ON acm.category_id = ac.category_id";
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
        throw new Exception("Could not persist article");
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
        throw new Exception("Could not update article");
    }
}

function deleteArticle($accountId, $articleId): void {
    $sql = "DELETE FROM articles WHERE account_id = :account_id AND article_id = :article_id";
    try {
        $statement = getConnection()->prepare($sql);
        $statement->bindValue("account_id", $accountId, PDO::PARAM_INT);
        $statement->bindValue("article_id", $articleId, PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) throw new PDOException("Could not delete article");
    } catch (PDOException $exception) {
        throw new Exception("Could not delete article");
    }
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
