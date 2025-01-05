<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit();
}

if (!isset($_POST['id']) || !isset($_POST['task_text'])) {
    echo "Task ID and text are required.";
    exit();
}

$id = $_POST['id'];
$taskText = $_POST['task_text'];

$query = "UPDATE tasks SET task_text = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $taskText, $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error updating task: " . $conn->error;
}

$stmt->close();
$conn->close();
?>