<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
    exit();
}

$user_email = $_SESSION['email'];
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

$query = "SELECT id, task_text, task_date, is_completed, is_starred FROM tasks WHERE user_email = ? AND task_text LIKE ? ORDER BY task_date ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $user_email, $search);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $completedClass = $row['is_completed'] ? 'completed' : '';
        $starredClass = $row['is_starred'] ? 'starred' : '';
        $starChecked = isset($row['is_starred']) && $row['is_starred'] ? 'fa-star' : 'fa-star-o';
        $checked = $row['is_completed'] ? 'checked' : '';
        $taskDate = date("Y-m-d", strtotime($row['task_date']));
        echo "
        <li class='task-item $completedClass'>
            <input type='checkbox' $checked onclick='toggleTask({$row['id']}, this.checked)'>
            <span class='task-text'>{$row['task_text']}</span>
            <span class='task-date'>" . date("F j, Y", strtotime($taskDate)) . "</span>
            <i class='fa fa-star $starChecked' onclick='toggleStar({$row['id']})'></i>
            <i class='fa-solid fa-pen edit-icon' onclick='openEditModal({$row['id']}, \"{$row['task_text']}\", \"$taskDate\")'></i>
            <i class='fa-solid fa-trash delete-icon' onclick='deleteTask({$row['id']})'></i>
        </li>";
    }
} else {
    echo "<li>You have not added any tasks yet.</li>";
}

$stmt->close();
$conn->close();
?>
