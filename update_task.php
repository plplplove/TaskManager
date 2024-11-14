<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
    exit();
}

$id = $_POST['id'];
$task_text = $_POST['task_text'];
$task_date = $_POST['task_date'];

$stmt = $conn->prepare("UPDATE tasks SET task_text = ?, task_date = ? WHERE id = ?");
$stmt->bind_param("ssi", $task_text, $task_date, $id);

if ($stmt->execute()) {
    echo "Task successfully updated";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
?>