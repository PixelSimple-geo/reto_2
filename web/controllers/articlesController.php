<?php

function getArticles() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $errorMessage = null;
    try {
        $articles = getAllArticles();
    } catch (PDOException $exception) {
        $errorMessage = "Hubo un error al intentar extraer tus articulos";
    } catch (RuntimeException $exception) {
        $errorMessage = "No se ha encontrado ninguna sesión";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articleNews.view.php";
}

function getArticlesCrudReadAll(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    try {
        $userAccount = getUserAccountFromSession();
        $articles = getArticlesByAccountId($userAccount["accountId"]);
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articlesCrudReadAll.view.php";
    } catch (PDOException $exception) {
        //TODO
        echo $exception->getMessage();
    } catch (RuntimeException $exception) {
        echo $exception->getMessage();
    }
}

function getArticlesCrudAdd(): void {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    try {
        $categories = getAllArticlesCategories();
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articlesCrudAdd.view.php";
    } catch (PDOException $exception) {
        //TODO
    }

}

function postArticlesCrudAdd(): void {
    validateRequiredParameters(["title", "description", "category_id"]);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $title = $_POST["title"];
    $description = $_POST["description"];
    $categoryId = $_POST["category_id"];
    try {
        $userAccount = getUserAccountFromSession();
        persistArticle($userAccount["accountId"], $title, $description, $categoryId);
        header("Location: /articles/crud/all", true, 303);
    } catch (PDOException $exception) {
        //TODO
        echo $exception->getMessage();
    } catch (RuntimeException $exception){
        echo $exception->getMessage();
    }
}

function getArticlesCrudEdit(): void {
    validateRequiredParameters(["article_id"], "GET");
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $articleId = $_GET["article_id"];
    try {
        $article = getArticle($articleId);
        $categories = getAllArticlesCategories();
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articlesCrudEdit.view.php";
    } catch (PDOException $exception) {
        //TODO
        echo $exception->getMessage();
    }
}

function postArticlesCrudEdit(): void {
    validateRequiredParameters(["article_id", "title", "description", "category_id"]);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $articleId = $_POST["article_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $categoryId = $_POST["category_id"];

    try {
        updateArticle($articleId, $title, $description, $categoryId);
        header("Location: /articles/crud/all", true, 303);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }

}

function getArticlesCrudDelete(): void {
    validateRequiredParameters(["article_id"], "GET");
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $articleId = $_GET["article_id"];
    try {
        $userAccount = getUserAccountFromSession();
        deleteArticle($userAccount["accountId"], $articleId);
        header("Location: /articles/crud/all", true, 303);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    } catch (RuntimeException $exception) {
        echo $exception->getMessage();
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesView/articleNews.view.php";
}

function getArticleById() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/commentariesDB.php";
    $errorMessage = null;
    $article = null;

    try {
        if (isset($_GET['articleId'])) {
            $userAccount = getUserAccountFromSession();
            $articleId = $_GET['articleId'];
            $article = getArticle($articleId);
            $commentaries = getAllArticleCommentaries($articleId, $userAccount);
        }
    } catch (PDOException $exception) {
        $errorMessage = "Hubo un error al intentar obtener el artículo.";
    } catch (RuntimeException $exception) {
        $errorMessage = "No se ha encontrado ninguna sesión.";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articleClient.view.php";
}