<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
    exit();
}

$user_email = $_SESSION['email'];
$task_text = $_POST['task_text'];
$task_date = $_POST['task_date'];

$stmt = $conn->prepare("INSERT INTO tasks (user_email, task_text, task_date) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user_email, $task_text, $task_date);

if ($stmt->execute()) {
    echo "Task added successfully";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>