<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'users';

try {
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if (!$conn->query($sql)) {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    $conn->select_db($database);
    $conn->set_charset("utf8mb4");
    
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating users table: " . $conn->error);
    }
    
    $sql = "CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_email VARCHAR(255) NOT NULL,
        task_text VARCHAR(255) NOT NULL,
        task_date DATE NOT NULL,
        is_completed BOOLEAN DEFAULT FALSE,
        is_starred BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_email) REFERENCES users(email) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating tasks table: " . $conn->error);
    }

} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}
?>