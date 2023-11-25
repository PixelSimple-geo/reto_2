<?php

function adminReadArticles(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/articlesDB.php";
    $articles = getAllArticles();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminArticles.view.php";
}

function adminDeleteArticle(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/articlesDB.php";
    $articleId = $_GET["article_id"];
    try {
        deleteArticle($articleId);
        header("Location: /admin/articles/read", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}
