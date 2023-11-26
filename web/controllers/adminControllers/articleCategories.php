<?php

function adminReadArticlesCategories(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/articlesDB.php";
    $categories = getAllArticlesCategories();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminArticlesCategories.view.php";
}

function adminAddArticlesCategories(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/articlesDB.php";
    $name = $_POST["name"];
    try {
        persistArticleCategory($name);
        header("Location: /admin/articlesCategories/read", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function adminDeleteArticleCategory(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/articlesDB.php";
    $categoryId = $_GET["category_id"];
    try {
        deleteArticleCategory($categoryId);
        header("Location: /admin/articlesCategories/read", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}
