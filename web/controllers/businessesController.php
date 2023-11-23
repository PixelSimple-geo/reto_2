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
        if (str_contains("No business found", $exception->getMessage())) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_400_.view.php";
            die();
        }
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
        if (str_contains("No business found", $exception->getMessage())) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/views/errorViews/error_400_.view.php";
            die();
        }
    }
}

function getBusinessesCrudReadAll(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    if (isset($_GET["feedback"])) $feedback = $_GET["feedback"];
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
        $category = $_POST["business_category"];
        $contacts = processContacts($_POST["contact_type"] ?? [], $_POST["contact_value"] ?? []);
        $addresses = processAddresses($_POST["addresses"] ?? [], $_POST["postal_codes"] ?? []);

        persistBusiness($userAccount["accountId"], $name, $description, $category, $contacts, $addresses);
        header("Location: /businesses/crud/all", true, 303);
    } catch (Exception $exception) {
        if (str_contains("Invalid parameter", $exception->getMessage())) {
            http_response_code(400);
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_400_.view.php";
            die();
        }
        if (str_contains("Business name is not unique", $exception->getMessage())) {
            $feedback = "Ya existe un negocio con ese nombre.";
            $businessCategories = getAllBusinessCategories();
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudAdd.view.php";
            die();
        }
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
        $category = $_POST["business_category"];
        $contacts = processContacts($_POST["contact_type"] ?? [], $_POST["contact_value"] ?? []);
        $addresses = processAddresses($_POST["addresses"] ?? [], $_POST["postal_codes"] ?? []);

        updateBusiness($businessId, $name, $description, $category, $contacts, $addresses);
        header("Location: /businesses/crud/all", true, 303);
    } catch (Exception $exception) {
        if ($exception->getCode() == 23000) {
            $feedback = "Ya existe un negocio con ese nombre. Elige otro";
            $categories = getAllBusinessCategories();
            $business = ["businessId" => $businessId, "name" => $name, "description" => $description,
                "category" => ["categoryId" => $category], "contacts" => $contacts, "addresses" => $addresses];
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudEdit.view.php";
        } else include_once $_SERVER["DOCUMENT_ROOT"] . "/views/errorViews/error_400_.view.php";
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
    } catch (Exception $exception) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_500_.view.php";
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
    if (count($addresses) === count($postalCodes)) {
        foreach ($addresses as $index => $address) {
            if (!empty($address) && !empty($postalCodes[$index])) {
                $processedAddresses[] = ["address" => $address, "postalCode" => $postalCodes[$index]];
            }
        }
    }
    return $processedAddresses;
}