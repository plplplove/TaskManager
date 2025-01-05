<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode([]);
    exit();
}

$user_email = $_SESSION['email'];

// Оновлений SQL-запит з додаванням колонки `id`
$query = "SELECT id, task_text, task_date FROM tasks WHERE user_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = [
        'id' => $row['id'],         
        'title' => $row['task_text'], 
        'start' => $row['task_date']  
    ];
}

echo json_encode($tasks);

$stmt->close();
$conn->close();
?>