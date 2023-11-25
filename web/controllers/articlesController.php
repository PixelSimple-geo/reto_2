<?php

function getArticles(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $categories = getAllArticlesCategories();
    if (!empty($_GET["category_id"])) $articles = getAllArticlesByCategory($_GET["category_id"]);
    else $articles = getAllArticles();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articleNews.view.php";
}

function getArticlesCrudReadAll(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $userAccount = getUserAccountFromSession();
    $articles = getArticlesByAccountId($userAccount["accountId"]);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articlesCrudReadAll.view.php";
}

function getArticlesCrudAdd(): void {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $categories = getAllArticlesCategories();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articlesCrudAdd.view.php";
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
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function getArticlesCrudEdit(): void {
    validateRequiredParameters(["article_id"], "GET");
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $articleId = $_GET["article_id"];
    try {
        verifyArticleOwnership($articleId);
        $article = getArticle($articleId);
        $categories = getAllArticlesCategories();
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articlesCrudEdit.view.php";
    } catch (Exception $exception) {
        if (str_contains($exception->getMessage(), "no record was found")) error_404_NotFound();
        error_500_InternalServerError();
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
        verifyArticleOwnership($articleId);
        updateArticle($articleId, $title, $description, $categoryId);
        header("Location: /articles/crud/all", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function getArticlesCrudDelete(): void {
    validateRequiredParameters(["article_id"], "GET");
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    $articleId = $_GET["article_id"];
    try {
        verifyArticleOwnership($articleId);
        $userAccount = getUserAccountFromSession();
        deleteArticle($userAccount["accountId"], $articleId);
        header("Location: /articles/crud/all", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function getArticleById(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/articlesDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/commentariesDB.php";
    validateRequiredParameters(["articleId"], "GET");
    try {
        $userAccount = getUserAccountFromSession();
        $articleId = $_GET['articleId'];
        $article = getArticle($articleId);
        if (!empty($userAccount)) $commentaries = getAllArticleCommentaries($articleId, $userAccount["accountId"]);
        else $commentaries = getAllArticleCommentaries($articleId, null);
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesViews/articleClient.view.php";
    } catch (Exception $exception) {
        if (str_contains($exception->getMessage(), "no record was found")) error_404_NotFound();
        error_500_InternalServerError();
    }
}

function verifyArticleOwnership($articleId): void {
    $userAccount = getUserAccountFromSession();
    if (!doesAccountOwnArticle($userAccount["accountId"], $articleId)) error_401_Unauthorized();
}