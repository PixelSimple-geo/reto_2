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

function getAdvertsCrudAdd(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["business_id"], "GET");
    try {
        $businessId = $_GET["business_id"];
        $categories = getAllBusinessAdvertCategories($businessId);
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/advertsCrudAdd.view.php";
    } catch (PDOException $exception) {}
}

function postAdvertsCrudAdd(): void {
    validateRequiredParameters(["title", "description", "business_id"]);
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

    if (isset($_POST["advert_category"])) $categoryId = $_POST["advert_category"];
    try {
        persistAdvert($businessId, $title, $description, $coverURI, 1, $categoryId, $characteristic, $imagesURI);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    } catch (PDOException $exception) {

    }
}

function getAdvertsCrudEdit(): void {
    validateRequiredParameters(["advert_id", "business_id"], "GET");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    try {
        $advert = getAdvert($_GET["advert_id"]);
        $businessId = $_GET["business_id"];
        $categories = getAllBusinessAdvertCategories($businessId);
        $advertSelectedCategories = [];
        foreach ($advert["categories"] as $category) {
            $advertSelectedCategories[] = $category["categoryId"];
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/advertsCrudEdit.view.php";
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
}

function postAdvertsCrudEdit(): void {
    validateRequiredParameters(["title", "description", "business_id", "advert_id"]);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";

    $businessId = $_POST["business_id"];
    $advertId = $_POST["advert_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $imagesURI = (saveImages());
    $characteristic = [];
    $categoryId = null;
    $imagesToDelete = [];
    $coverURI = null;

    if (isset($_POST["cover_img_url"])) {
        $coverURI = $_POST["cover_img_url"];
    } else if ($_FILES["cover_img"]["error"] === UPLOAD_ERR_OK) {
        $coverURI = saveImage();
    }

    if (isset($_POST["images_ids"])) {
        $imagesToDelete = $_POST["images_ids"];
    }

    if (isset($_POST["characteristic_type"]) && isset($_POST["characteristic_value"])
        && count($_POST["characteristic_type"]) === count($_POST["characteristic_value"])) {
        $characteristicType = $_POST["characteristic_type"];
        $characteristicValue = $_POST["characteristic_value"];
        foreach ($characteristicType as $index => $type) {
            $characteristic[] = ["type" => $type, "value" => $characteristicValue[$index]];
        }
    }

    if (isset($_POST["advert_category"])) $categoryId = $_POST["advert_category"];
    try {
        updateAdvert($advertId, $title, $description, $coverURI, $categoryId,
            $characteristic, $imagesURI, $imagesToDelete);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    } catch (PDOException $exception) {
        echo $exception->getMessage();
    }
}

function getAdvertsCrudDelete(): void {
    validateRequiredParameters(["business_id", "advert_id"], "GET");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";

    $businessId = $_GET["business_id"];
    $advertId = $_GET["advert_id"];

    try {
        deleteAdvert($advertId);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    } catch (PDOException $exception) {

    }

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
