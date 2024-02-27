<?php

include '../private/conn.php';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->exec("USE $dbname");

    // Read SQL queries from file
    $sqlFile = 'digidate.sql';
    $sqlQueries = file_get_contents($sqlFile);

    // Execute the SQL queries
    $conn->exec($sqlQueries);

    echo "Database creation and data insertion successful.";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}