<?php

function getAllCities() :array {
    try {
        $sql = "SELECT city_id AS cityId, name FROM cities;";
        $statement = getConnection()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        throw $exception;
    }
}