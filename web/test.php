<?php

// Database configuration
$host = 'mysql';
$port = '3306'; // Use the MySQL port
$dbname = 'reto_2';
$user = 'root';
$password = 'root';
$charset = 'utf8mb4';

// PDO connection
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    // SQL query to retrieve data from the 'authorities' table
    $sql = "SELECT * FROM authorities";
    $stmt = $pdo->query($sql);

    // Fetch the data
    while ($row = $stmt->fetch()) {
        // Process each row of data
        print_r($row);
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}