<?php


function getBusinesses() :void {
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
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/businesses.view.php";
}

function getAddBusinesses() :void {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/businessesDB.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/models/citiesDB.php";
    $businessCategories = getAllBusinessCategories();
    $cities = getAllCities();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/createBusiness.view.php";
}

function postBusiness() :void {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    if (isset($_POST["name"]) && isset($_POST["description"])) {
        try {
            $userAccount = getUserAccountFromSession();
            $name = $_POST["name"];
            $description = $_POST["description"];
            $category = $_POST["business_category"];
            $contactsParam = $_POST['contacts'];
            $contactsArray = [];
            foreach ($contactsParam['type'] as $index => $type) {
                $value = $contactsParam['value'][$index];
                $contactsArray[] = ["type" => $type, "value" => $value];
            }
            $addressesParam = $_POST["addresses"];
            $addressesArray = [];
            foreach ($addressesParam['address'] as $index => $address) {
                $postalCode = $addressesParam['postal_code'][$index];
                $cityId = $addressesParam["city_id"][$index];
                $addressesArray[] = ["address" => $address, "postalCode" => $postalCode, "cityId" => $cityId];
            }
            persistBusiness($userAccount["accountId"], $name, $description, $category, $contactsArray, $addressesArray);
            header("Location: /account/businesses", true, 303);
            print_r($addressesArray);
        } catch (PDOException $exception) {
            $errorMessage = "No se ha podido registrar tu negocio";
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/createBusiness.view.php";
        } catch (Exception $exception) {
            $errorMessage = "Hubo un error: " . $exception->getMessage();
            include_once $_SERVER["DOCUMENT_ROOT"] . "/views/createBusiness.view.php";
        }
    }
}

function getEditBusiness() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $businessId = $_GET["business_id"];
    $business = getBusiness($businessId);
    print_r($business);
    $categories = getAllBusinessCategories();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/views/editBusiness.view.php";
}