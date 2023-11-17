<?php

function getAdvertBusinessAccount(): void {
    if (empty($_GET["business_id"])) include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $userAccount = getUserAccountFromSession();
    $business = getBusiness($_GET["business_id"]);
    $adverts = getAdvertsByBusinessId($_GET["business_id"]);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/adverts.view.php";
}

function getAddAdvertBusinessAccount(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    if (empty($_GET["business_id"])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
        return;
    }
    $businessId = $_GET["business_id"];
    $categories = getAllBusinessAdvertCategories($businessId);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/advertsCreate.view.php";
}

function postAddAdvertBusinessAccount(): void {
    if (empty($_POST["title"]) || empty($_POST["description"]) || empty($_POST["business_id"]) ) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
        return;
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";

    $businessId = $_POST["business_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $imagesURI = (saveImages());
    $coverURI = null;
    $categoryId = null;
    $characteristic = [];

    if ($_FILES["cover_img"]["error"] === UPLOAD_ERR_OK) {
        $coverURI = saveImage();
    }

    if (isset($_POST["characteristic_type"]) && isset($_POST["characteristic_value"])
    && count($_POST["characteristic_type"]) === count($_POST["characteristic_value"])) {
        $characteristicType = $_POST["characteristic_type"];
        $characteristicValue = $_POST["characteristic_value"];
        foreach ($characteristicType as $index => $type) {
            $characteristic[] = ["type" => $type, "value" => $characteristicValue[$index]];
        }
    }

    if (isset($_POST["advert_category"]))
        $categoryId = $_POST["advert_category"];

    persistAdvert($businessId, $title, $description, $coverURI, 1, $categoryId, $characteristic, $imagesURI);
    header("Location: /adverts/account/business?business_id=$businessId", true, 303);
}

function getEditAdvertBusinessAccount(): void {
    if (empty($_GET["advert_id"])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
        return;
    }
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    $advert = getAdvert($_GET["advert_id"]);
    print_r($advert);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/advertsEdit.view.php";
}

function saveImage(): string {
    $targetDirectory = $_SERVER["DOCUMENT_ROOT"] . "/statics/uploads/";
    $fileName = uniqid() . "_" . basename($_FILES["cover_img"]["name"]);
    $targetFile = $targetDirectory . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }
    if ($uploadOk == 1) {
        move_uploaded_file($_FILES["cover_img"]["tmp_name"], $targetFile);
    }
    return "/statics/uploads/$fileName";
}

function saveImages(): array {
    $images = [];
    $targetDirectory = $_SERVER["DOCUMENT_ROOT"] . "/statics/uploads/";
    print_r($_FILES["images"]);
    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        $fileName = uniqid() . "_" . basename($_FILES["images"]["name"][$key]);
        $targetFile = $targetDirectory . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            continue;
        }
        $images[] = "/statics/uploads/$fileName";
        move_uploaded_file($tmp_name, $targetFile);
    }
    return $images;
}
