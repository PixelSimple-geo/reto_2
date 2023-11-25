<?php

function adminReadBusinesses(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    $businesses = getAllBusinesses();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminBusinesses.view.php";
}

function adminDeleteBusiness(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    $businessId = $_GET["business_id"];
    try {
        deleteBusiness($businessId);
        header("Location: /admin/businesses/read", true, 303);
    } catch (Exception $exception) {
        echo $exception->getMessage();
        error_500_InternalServerError();
    }
}

