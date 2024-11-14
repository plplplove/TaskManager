<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorised";
    exit();
}

$id = $_POST['id'];

$query = "DELETE FROM tasks WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Task deleted successfully";
} else {
    echo "Error deleting task: " . $conn->error;
}

$stmt->close();
$conn->close();
?>