<?php
// Realiza la conexión a la base de datos
$host = "127.0.0.1";
$user = "admin";
$pass = "admin";
$dbname = "reto_2";
$port = "3306"; 

$mensaje = "";

function connect($host, $dbname, $user, $pass, $port){
    try {
        $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        return $dbh;
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        echo "hello";
    }
}

//Adverts
function getAdverts($dbh) {
    try {
        $query = "SELECT * FROM adverts";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $adverts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $adverts;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}


//Noticias
function getArticles($dbh) {
    try {
        $query = "SELECT * FROM articles";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

//Categories
function getBusinessCaregories($dbh) {
    try {
        $query = "SELECT * FROM businesses_categories";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}


$dbh = connect($host, $dbname, $user, $pass, $port);    
