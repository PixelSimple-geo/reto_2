<?php
/*
function getAdvertBusinessAccount(): void {
    if (empty($_GET["business_id"])) include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400_.view.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    try {
        $userAccount = getUserAccountFromSession();
        $business = getBusiness($_GET["business_id"]);
        $adverts = getAdvertsByBusinessId($_GET["business_id"]);
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/adverts.view.php";
    } catch (Exception $exception) {
        if (str_contains( $exception->getMessage(), "no record found")) error_404_NotFound();
        error_500_InternalServerError();
    }
}
*/

function getAdvertsCrudAdd(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["business_id"], "GET");
    $businessId = $_GET["business_id"];
    $categories = getAllBusinessAdvertCategories($businessId);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/advertsCrudAdd.view.php";
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

    if ($_FILES["cover_img"]["error"] === UPLOAD_ERR_OK) $coverURI = saveImage();

    if (isset($_POST["characteristic_type"]) && isset($_POST["characteristic_value"])
    && count($_POST["characteristic_type"]) === count($_POST["characteristic_value"])) {
        $characteristicType = $_POST["characteristic_type"];
        $characteristicValue = $_POST["characteristic_value"];
        foreach ($characteristicType as $index => $type)
            $characteristic[] = ["type" => $type, "value" => $characteristicValue[$index]];
    }

    if (isset($_POST["advert_category"])) $categoryId = $_POST["advert_category"];
    try {
        persistAdvert($businessId, $title, $description, $coverURI, 1, $categoryId, $characteristic, $imagesURI);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    } catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function getAdvertsCrudEdit(): void {
    validateRequiredParameters(["advert_id", "business_id"], "GET");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $advertId = $_GET["advert_id"];
    try {
        verifyAdvertOwnership($advertId);
        $advert = getAdvert($advertId);
        $businessId = $_GET["business_id"];
        $categories = getAllBusinessAdvertCategories($businessId);
        $advertSelectedCategories = [];
        foreach ($advert["categories"] as $category) {
            $advertSelectedCategories[] = $category["categoryId"];
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/advertsCrudEdit.view.php";
    } catch (Exception $exception) {
        if (str_contains($exception->getMessage(), "no record was found")) error_404_NotFound();
        error_500_InternalServerError();
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
    verifyAdvertOwnership($advertId);

    if (isset($_POST["cover_img_url"])) $coverURI = $_POST["cover_img_url"];
    else if ($_FILES["cover_img"]["error"] === UPLOAD_ERR_OK) $coverURI = saveImage();

    if (isset($_POST["images_ids"])) $imagesToDelete = $_POST["images_ids"];

    if (isset($_POST["characteristic_type"]) && isset($_POST["characteristic_value"])
        && count($_POST["characteristic_type"]) === count($_POST["characteristic_value"])) {
        $characteristicType = $_POST["characteristic_type"];
        $characteristicValue = $_POST["characteristic_value"];
        foreach ($characteristicType as $index => $type)
            $characteristic[] = ["type" => $type, "value" => $characteristicValue[$index]];
    }

    if (isset($_POST["advert_category"])) $categoryId = $_POST["advert_category"];
    try {
        updateAdvert($advertId, $title, $description, $coverURI, $categoryId,
            $characteristic, $imagesURI, $imagesToDelete);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    }catch (ValueError $exception) {
        error_400_BadRequest();
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function getAdvertsCrudDelete(): void {
    validateRequiredParameters(["business_id", "advert_id"], "GET");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";

    $businessId = $_GET["business_id"];
    $advertId = $_GET["advert_id"];
    verifyAdvertOwnership($advertId);
    try {
        deleteAdvert($advertId);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    } catch (Exception $exception) {error_500_InternalServerError();}
}

function saveImage(): string {
    $targetDirectory = $_SERVER["DOCUMENT_ROOT"] . "/statics/uploads/";
    $fileName = uniqid() . "_" . basename($_FILES["cover_img"]["name"]);
    $targetFile = $targetDirectory . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
        $uploadOk = 0;
    if ($uploadOk == 1) move_uploaded_file($_FILES["cover_img"]["tmp_name"], $targetFile);
    return "/statics/uploads/$fileName";
}

function saveImages(): array {
    $images = [];
    $targetDirectory = $_SERVER["DOCUMENT_ROOT"] . "/statics/uploads/";
    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        $fileName = uniqid() . "_" . basename($_FILES["images"]["name"][$key]);
        $targetFile = $targetDirectory . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
            continue;
        $images[] = "/statics/uploads/$fileName";
        move_uploaded_file($tmp_name, $targetFile);
    }
    return $images;
}

function getAdverts() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    if (!empty($_GET["q"]))
        $searchParameter = $_GET["q"];
    else $searchParameter = null;
    $adverts = getAllAdverts($searchParameter);
    $advertCategories = getAllAdvertCategories();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/products.view.php";
}

function getAdvertPage() :void {
    validateRequiredParameters(["advert_id"], "GET");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    try {
        $advertId = $_GET['advert_id'];
        $advert = getAdvert($advertId);
        $advertImages = getAdvertImages($advertId);
        $categories = getAdvertCategories($advertId);
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/advertsViews/advertsClient.view.php";
    } catch (Exception $exception) {
        if (str_contains($exception->getMessage(), "no record was found")) error_404_NotFound();
        error_500_InternalServerError();
    }
}

function verifyAdvertOwnership($advertId): void {
    $userAccount = getUserAccountFromSession();
    if(!doesAccountOwnAdvert($userAccount["accountId"], $advertId)) error_401_Unauthorized();
}