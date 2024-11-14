<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
    exit();
}

$email = $_SESSION['email'];
$oldPassword = $_POST['old_password'];
$newPassword = $_POST['new_password'];

$query = "SELECT password FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashedPassword);

if ($stmt->num_rows === 1) {
    $stmt->fetch();
    


    if (md5($oldPassword) == $hashedPassword) {
        $newHashedPassword = md5($newPassword); 
        $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $newHashedPassword, $email);
    
        if ($updateStmt->execute()) {
            echo "Password successfully changed!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    
        $updateStmt->close();
    } else {
        echo "Incorrect old password!";
    }
} else {
    echo "User not found!";
}

$stmt->close();
$conn->close();
?>