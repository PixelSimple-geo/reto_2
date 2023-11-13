<?php



function getAuthorities($connection) :array {
    $statement = $connection->query("SELECT * FROM authorities");
    return $statement->fetchAll();
}

function addAuthority($connection, $roleName) {
    $statement = $connection->prepare("INSERT INTO authorities(role) VALUES(:role)");
    $statement->execute(["role" => $roleName]);
}

