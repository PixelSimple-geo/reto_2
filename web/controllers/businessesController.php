<?php

function getAccountBusinesses() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $errorMessage = null;
    try {
        $userAccount = getUserAccountFromSession();
        $businesses = getAllAccountBusinesses($userAccount["accountId"]);
    } catch (PDOException $exception) {
        $errorMessage = "Hubo un error al intentar extraer tus negocios";
    } catch (RuntimeException $exception) {
        $errorMessage = "No se ha encontrado ninguna sesión";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/businesses.view.php";
}

function getAddBusinesses() :void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    $userAccount = getUserAccountFromSession();
    $businessCategories = getAllBusinessCategories();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessCreate.view.php";
}

function postBusiness() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    if (empty($_POST["name"]) || empty($_POST["description"]) || empty($_POST["business_category"])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php"; 
        return;
    }
    try {
        $userAccount = getUserAccountFromSession();
        $name = $_POST["name"];
        $description = $_POST["description"];
        $category = $_POST["business_category"];
        $contacts = processContacts($_POST["contact_type"] ?? [], $_POST["contact_value"] ?? []);
        $addresses = processAddresses($_POST["addresses"] ?? [], $_POST["postal_codes"] ?? []);

        persistBusiness($userAccount["accountId"], $name, $description, $category, $contacts, $addresses);
        header("Location: /businesses/account/get", true, 303);
    } catch (PDOException $exception) {
        $errorMessage = "No se ha podido registrar tu negocio";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessCreate.view.php";
    } catch (Exception $exception) {
        $errorMessage = "Hubo un error: " . $exception->getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessCreate.view.php";
    }
}

function getEditBusiness() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $userAccount = getUserAccountFromSession();
    $businessId = $_GET["business_id"];
    $business = getBusiness($businessId);
    $categories = getAllBusinessCategories();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessEdit.view.php";
}

function postEditBusiness() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    if (empty($_POST["business_id"]) || empty($_POST["name"]) || empty($_POST["description"]) ||
        empty($_POST["business_category"])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/views/error_400.view.php";
        return;
    }
    try {
        $userAccount = getUserAccountFromSession();
        $businessId = $_POST["business_id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $category = $_POST["business_category"];
        $contacts = processContacts($_POST["contact_type"] ?? [], $_POST["contact_value"] ?? []);
        $addresses = processAddresses($_POST["addresses"] ?? [], $_POST["postal_codes"] ?? []);

        updateBusiness($userAccount["accountId"], $businessId, $name, $description, $category, $contacts, $addresses);
        header("Location: /businesses/account/get", true, 303);
    } catch (PDOException $exception) {
        $errorMessage = "No se ha podido registrar tu negocio";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessEdit.view.php";
    } catch (Exception $exception) {
        $errorMessage = "Hubo un error: " . $exception->getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessEdit.view.php";
    }
}

function deleteAccountBusiness() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $businessId = $_GET["business_id"];
    $userAccount = getUserAccountFromSession();
    deleteBusiness($userAccount["accountId"], $businessId);
    header("Location: /businesses/account/get", true, 303);
}

function processContacts(array $types, array $values) :array {
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

function processAddresses(array $addresses, array $postalCodes) :array {
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

function getCategories() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $errorMessage = null;
    $businesses = []; 

    try {
        $categories = getAllBusinessCategories();
        $businesses = getAllBusinesses();
    } catch (PDOException $exception) {
        $errorMessage = "Hubo un error al intentar extraer tus categorias";
    } catch (RuntimeException $exception) {
        $errorMessage = "No se ha encontrado ninguna sesión";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/comerces.view.php";
}

function getBusinessesByCategorie() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $errorMessage = null;
    $businessesByCategorie = []; 

    try {
        if (isset($_GET['categoryId'])) {
            $categoryId = $_GET['categoryId'];
            $businessesByCategorie = getAllBusinessesByCategory($categoryId);
        }
    } catch (PDOException $exception) {
        $errorMessage = "Hubo un error al intentar extraer tus negocios";
    } catch (RuntimeException $exception) {
        $errorMessage = "No se ha encontrado ninguna sesión";
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/categories.view.php";
}
