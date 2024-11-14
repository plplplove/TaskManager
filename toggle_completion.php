<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
    exit();
}

$id = $_POST['id'];
$is_completed = $_POST['is_completed'];

$query = "UPDATE tasks SET is_completed = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $is_completed, $id);

if ($stmt->execute()) {
    echo "Task completion status updated successfully";
} else {
    echo "Error updating task completion status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>