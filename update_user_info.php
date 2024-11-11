<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorised";
    exit();
}

$email = $_SESSION['email'];

$field = $_POST['field'];
$value = $_POST['value'];

if ($field == "username" || $field == "email") {
    $stmt = $conn->prepare("UPDATE users SET $field = ? WHERE email = ?");
    $stmt->bind_param("ss", $value, $email);
    
    if ($stmt->execute()) {
        if ($field == "email") {
            $_SESSION['email'] = $value;
        }
        echo "Успішно оновлено";
    } else {
        echo "Eror: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Invalid field";
}

$conn->close();
?>