<?php
session_start();
include 'connect.php';
include_once __DIR__ . '/lang/language_handler.php'; // Підключення для перекладу

if (!isset($_SESSION['email'])) {
    echo $langData['not_authorized']; // Використання перекладу
    exit();
}

$id = $_POST['id'];

$query = "UPDATE tasks SET is_starred = NOT is_starred WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo $langData['task_starred_updated']; // Використання перекладу
} else {
    echo $langData['error_updating_starred']; // Використання перекладу
}

$stmt->close();
$conn->close();
?>