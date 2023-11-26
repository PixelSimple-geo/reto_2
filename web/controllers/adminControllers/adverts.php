<?php

function adminReadAdverts(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/advertsDB.php";
    $adverts = getAllAdverts();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/adminViews/adminAdverts.view.php";
}

function adminDeleteAdvert(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/advertsDB.php";
    $advertId = $_GET["advert_id"];
    try {
        deleteAdvert($advertId);
        header("Location: /admin/adverts/read", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}
