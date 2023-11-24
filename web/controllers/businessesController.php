<?php

function getBusinessPage(): void {
    validateRequiredParameters(["business_id"], "GET");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/reviewsDB.php";
    try {
        $userAccount = getUserAccountFromSession();
        $businessId = $_GET['business_id'];
        $business = getBusiness($businessId);
        $adverts = getAdvertsByBusinessId($businessId);
        $reviews = getAllBusinessReviews($businessId, $userAccount);
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/business.view.php";
    } catch (Exception $exception) {
        if (str_contains("no record found", $exception->getMessage())) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_404_.view.php";
            die();
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_500_.view.php";
    }
}

function getBusinesses(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $categories = getAllBusinessCategories();
    if (!empty($_GET["category_id"])) $businesses = getAllBusinessesByCategory($_GET["category_id"]);
    else $businesses = getAllBusinesses();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/businesses.view.php";
}

function getBusinessesCrudRead(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    try {
        validateRequiredParameters(["business_id"], "GET");
        $business = getBusiness($_GET["business_id"]);
        $contacts = $business["contacts"];
        $addresses = $business["addresses"];
        $category = $business["category"];
        $advertCategories = $business["advertCategories"];
        $adverts = getAdvertsByBusinessId($business["businessId"]);
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/businessesCrudRead.view.php";
    } catch (Exception $exception) {
        if (str_contains("no record found", $exception->getMessage())) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_404_.view.php";
            die();
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_500_.view.php";
    }
}

function getBusinessesCrudReadAll(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    if (isset($_GET["feedback"])) $feedback = $_GET["feedback"];
    if (isset($_GET["errorMessage"])) $errorMessage = $_GET["errorMessage"];
    $userAccount = getUserAccountFromSession();
    $businesses = getAllAccountBusinesses($userAccount["accountId"]);
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/businessesCrudReadAll.view.php";
}

function getBusinessesCrudAdd(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    try {
        $businessCategories = getAllBusinessCategories();
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudAdd.view.php";
    } catch (PDOException $exception) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_500_.view.php";
    }
}

function postBusinessesCrudAdd(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["name", "description", "business_category"]);
    try {
        $userAccount = getUserAccountFromSession();

        $name = $_POST["name"];
        $description = $_POST["description"];
        if (preg_match("/^\d$/", $_POST["business_category"]) === 1)
            $categoryId = $_POST["business_category"];
        else throw new ValueError("not a valid number");
        $contacts = processContacts($_POST["contact_type"] ?? [], $_POST["contact_value"] ?? []);
        $addresses = processAddresses($_POST["addresses"] ?? [], $_POST["postal_codes"] ?? []);
        $coverURI = null;

        if ($_FILES["cover_img"]["error"] === UPLOAD_ERR_OK) $coverURI = saveImage();

        persistBusiness($userAccount["accountId"], $name, $description, $coverURI, $categoryId, $contacts, $addresses);
        header("Location: /businesses/crud/all", true, 303);
    } catch (ValueError $exception) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_400_.view.php";
    } catch (Exception $exception) {
        if (str_contains("[name] unique constraint violation", $exception->getMessage())) {
            $feedback = "Ya existe un negocio con ese nombre.";
            $businessCategories = getAllBusinessCategories();
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudAdd.view.php";
            die();
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_500_.view.php";
    }
}

function getBusinessesCrudEdit(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["business_id"], "GET");
    try {
        $businessId = $_GET["business_id"];
        $business = getBusiness($businessId);
        $categories = getAllBusinessCategories();
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudEdit.view.php";
    } catch (Exception $exception) {
        if (str_contains("no record found", $exception->getMessage())) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_404_.view.php";
            die();
        }
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_500_.view.php";
    }
}

function postBusinessesCrudEdit(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["business_id", "name", "description", "business_category"]);
    try {
        $userAccount = getUserAccountFromSession();

        $businessId = $_POST["business_id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        if (preg_match("/^\d$/", $_POST["business_category"]) === 1)
            $categoryId = $_POST["business_category"];
        else throw new ValueError("not a valid number");
        $contacts = processContacts($_POST["contact_type"] ?? [], $_POST["contact_value"] ?? []);
        $addresses = processAddresses($_POST["addresses"] ?? [], $_POST["postal_codes"] ?? []);
        $coverURI = null;

        if(!empty($_POST["old_cover_img"])) $coverURI = $_POST["old_cover_img"];
        else if ($_FILES["cover_img"]["error"] === UPLOAD_ERR_OK) $coverURI = saveImage();

        updateBusiness($businessId, $name, $description, $coverURI, $categoryId, $contacts, $addresses);
        header("Location: /businesses/crud/all", true, 303);
    } catch (ValueError $exception) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_400_.view.php";
    } catch (Exception $exception) {
        if (str_contains("[name] unique constraint violation", $exception->getMessage())) {
            $feedback = "Ya existe un negocio con ese nombre.";
            $businessCategories = getAllBusinessCategories();
            $business = ["businessId" => $businessId, "name" => $name, "description" => $description,
                "category" => ["categoryId" => $categoryId], "contacts" => $contacts, "addresses" => $addresses];
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudAdd.view.php";
            die();
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_500_.view.php";
    }
}

function getBusinessesCrudDelete(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["business_id"], "GET");
    try {
        $businessId = $_GET["business_id"];
        deleteBusiness($businessId);
        header("Location: /businesses/crud/all", true, 303);
    } catch (Exception $exception) {
        if (str_contains("no row was deleted", $exception->getMessage())) {
            $error = "No se ha podido eliminar tu negocio. Si el error persiste contacta con soporte";
            header("Location: /businesses/crud/all?errorMessage=$error", true, 303);
            die();
        }
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_500_.view.php";
    }
}

function postBusinessesAdvertCategoryCrudAdd(): void {
    validateRequiredParameters(["business_id", "name"]);
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $businessId = $_POST["business_id"];
    $name = $_POST["name"];
    try {
        persistBusinessAdvertCategory($businessId, $name);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    } catch (ValueError $exception) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_400_.view.php";
    } catch (Exception $exception) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_500_.view.php";
    }
}

function deleteBusinessesAdvertCategoryCrudDelete(): void {
    validateRequiredParameters(["category_id", "business_id"], "GET");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $categoryId = $_GET["category_id"];
    $businessId = $_GET["business_id"];
    try {
        deleteBusinessAdvertCategory($categoryId);
        header("Location: /businesses/crud/business?business_id=$businessId", true, 303);
    } catch (Exception $exception) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_500_.view.php";
    }
}

function processContacts(array $types, array $values): array {
    $contacts = [];
    if (count($types) === count($values)) {
        foreach ($types as $index => $type) {
            if (!empty($type) && !empty($values[$index])) {
                $contacts[] = ["type" => $type, "value" => $values[$index]];
            }
        }
    }
    return $contacts;
}

function processAddresses(array $addresses, array $postalCodes): array {
    $processedAddresses = [];
    if (count($addresses) === count($postalCodes))
        foreach ($addresses as $index => $address)
            if (!empty($address) && !empty($postalCodes[$index])) {
                if (preg_match("/^\d{5}$/", $postalCodes[$index]) === 1)
                    $processedAddresses[] = ["address" => $address, "postalCode" => $postalCodes[$index]];
                else throw new ValueError("not a valid number");
            }

    return $processedAddresses;
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