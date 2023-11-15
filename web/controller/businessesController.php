<?php


function getBusinesses() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/businessesDB.php";
    $errorMessage = null;
    try {
        $userAccount = getUserAccountFromSession();
        $businesses = getAllAccountBusinesses($userAccount["accountId"]);
        print_r($userAccount);
        print_r($businesses);
    } catch (PDOException $exception) {
        $errorMessage = "Hubo un error al intentar extraer tus negocios";
    } catch (RuntimeException $exception) {
        $errorMessage = "No se ha encontrado ninguna sesión";
    }
    include_once $_SERVER['DOCUMENT_ROOT'] . "/views/negocios.view.php";
}

function postBusiness() {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/accountDB.php";
    if (isset($_POST["name"]) && isset($_POST["description"])) {
        $userAccount = getUserAccountFromSession();
        try {
            $name = $_POST["name"];
            $description = $_POST["description"];
            persistBusiness($userAccount["accountId"], $name, $description);
            //
        } catch (Exception $exception) {

        }
    }
}