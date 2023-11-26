<?php

function adminReadBusinessesCategories(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    $categories = getAllBusinessCategories();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminBusinessesCategories.view.php";
}

function adminAddBusinessesCategories(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    $name = $_POST["name"];
    try {
        persistBusinessCategory($name);
        header("Location: /admin/businessesCategories/read", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function adminDeleteBusinessCategory(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    $categoryId = $_GET["category_id"];
    try {
        deleteBusinessCategory($categoryId);
        header("Location: /admin/businessesCategories/read", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}
