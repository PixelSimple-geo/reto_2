<?php

function getBusinessesCrudRead(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";
    validateRequiredParameters(["business_id"], "GET");
    $business = getBusiness($_GET["business_id"]);
    $contacts = $business["contacts"];
    $addresses = $business["addresses"];
    $category = $business["category"];
    $advertCategories = $business["advertCategories"];
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/businessesCrudRead.view.php";
}

function getBusinessesCrudReadAll(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    if (isset($_GET["feedback"])) $feedback = $_GET["feedback"];
    try {
        $userAccount = getUserAccountFromSession();
        $businesses = getAllAccountBusinesses($userAccount["accountId"]);
    } catch (PDOException $exception) {
        $errorMessage = "Se ha producido un error al intentar extraer tus negocios";
    } catch (RuntimeException $exception) {
        header("Location: /login", true, 303);
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/businessesCrudReadAll.view.php";
}

function getBusinessesCrudAdd(): void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    try {
        $businessCategories = getAllBusinessCategories();
    } catch (PDOException $exception) {
        $errorMessage = "Se ha producido un error al intentar extraer las categorías";
    }
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudAdd.view.php";
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
    } catch (PDOException $exception) {
        if ($exception->getCode() == 23000) {
            $feedback = "Ya existe un negocio con ese nombre. Elige otro";
            $businessCategories = getAllBusinessCategories();
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudAdd.view.php";
        } else include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_400.view.php";
    } catch (RuntimeException $exception) {
        header("Location: /login", true, 303);
    }
}

function getBusinessesCrudEdit(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["business_id"], "GET");
    try {
        $businessId = $_GET["business_id"];
        $business = getBusiness($businessId);
        $categories = getAllBusinessCategories();
    } catch (PDOException $exception) {
        $errorMessage = $exception->getMessage();
        header("Location: /businesses/crud/all?feedback=$errorMessage", true, 303);
    } catch (RuntimeException $exception) {
        header("Location: /login", true, 303);
    }
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudEdit.view.php";
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

        updateBusiness($userAccount["accountId"], $businessId, $name, $description, $category, $contacts, $addresses);
        header("Location: /businesses/crud/all", true, 303);
    } catch (PDOException $exception) {
        if ($exception->getCode() == 23000) {
            $feedback = "Ya existe un negocio con ese nombre. Elige otro";
            $categories = getAllBusinessCategories();
            $business = ["businessId" => $businessId, "name" => $name, "description" => $description,
                "category" => ["categoryId" => $category], "contacts" => $contacts, "addresses" => $addresses];
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudEdit.view.php";
        } else include_once $_SERVER["DOCUMENT_ROOT"] . "/views/error_400.view.php";
    } catch (RuntimeException $exception) {
        header("Location: /login", true, 303);
        include_once $_SERVER["DOCUMENT_ROOT"] . "/views/businessesViews/businessesCrudEdit.view.php";
    }
}

function getBusinessesCrudDelete(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    validateRequiredParameters(["business_id"], "GET");
    try {
        $businessId = $_GET["business_id"];
        $userAccount = getUserAccountFromSession();
        deleteBusiness($userAccount["accountId"], $businessId);
        header("Location: /businesses/crud/all", true, 303);
    } catch (PDOException $exception) {
        $errorMessage = $exception->getMessage();
        header("Location: /businesses/crud/all?feedback=$errorMessage", true, 303);
    } catch (RuntimeException $exception) {
        header("Location: /login", true, 303);
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

function getCategories(): void {
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

function getBusinessesByCategorie(): void {
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

function businessClient(): void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/advertsDB.php";

    $errorMessage = null;
    $businessesClient = []; 
    $advertsByBusiness = [];

    try {
        if (isset($_GET['businessId'])) {
            $businessId = $_GET['businessId'];
            $businessesClient = getBusiness($businessId);
            $advertsByBusiness = getAdvertsByBusinessId($businessId);
        }
    } catch (PDOException $exception) {
        $errorMessage = "Hubo un error al intentar extraer tus categorias";
    } catch (RuntimeException $exception) {
        $errorMessage = "No se ha encontrado ninguna sesión";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businessesViews/businessClient.view.php";
} 