<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit();
}

if (!isset($_POST['id'])) {
    echo "Task ID is required.";
    exit();
}

$id = $_POST['id'];

$query = "DELETE FROM tasks WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error deleting task: " . $conn->error;
}

$stmt->close();
$conn->close();
?>