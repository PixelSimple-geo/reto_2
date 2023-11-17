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
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/articlesView/articleClient.view.php";
}