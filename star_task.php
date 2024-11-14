<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
    exit();
}

$id = $_POST['id'];

$query = "UPDATE tasks SET is_starred = NOT is_starred WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Task starred status updated successfully";
} else {
    echo "Error updating task star status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>