<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/models/driverManager.php";

function getAuthorities($connection): array {
    return $connection->query("SELECT authority_id authorityId, role FROM authorities")->fetchAll();
}

function addAuthority($connection, $roleName): void {
    $connection->prepare("INSERT INTO authorities(role) VALUES(:role)")->execute(["role" => $roleName]);
}

