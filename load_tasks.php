<?php
session_start();
include 'connect.php';
include 'lang/language_handler.php';

if (!isset($_SESSION['email'])) {
    echo htmlspecialchars($translations['not_authorized']);
    exit();
}

$user_email = $_SESSION['email'];
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

$query = "
    SELECT id, task_text, task_date, is_completed, is_starred 
    FROM tasks 
    WHERE user_email = ? 
      AND task_text LIKE ? 
    ORDER BY task_date ASC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $user_email, $search);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $taskId = $row['id'];
        $taskText = htmlspecialchars($row['task_text'], ENT_QUOTES);
        $taskDate = date("Y-m-d", strtotime($row['task_date']));
        $isCompleted = $row['is_completed'] ? true : false;
        $isStarred = $row['is_starred'] ? true : false;

        $completedClass = $isCompleted ? 'completed' : '';
        $starIconClass  = $isStarred ? 'fa-solid fa-star' : 'fa-regular fa-star';
        $checked = $isCompleted ? 'checked' : '';
        $formattedDate = date("F j, Y", strtotime($row['task_date']));

        echo "<li class='task-item $completedClass'>";
        echo "<input type='checkbox' $checked onclick='toggleTask($taskId, this.checked)'>";
        echo "<span class='task-text'>$taskText</span>";
        echo "<span class='task-date'>$formattedDate</span>";
        
        // Перемістіть іконку зірки після іконок редагування та видалення
        echo "<i class='fa-solid fa-pen edit-icon' onclick='openEditModal($taskId, \"$taskText\", \"$taskDate\")'></i>";
        echo "<i class='fa-solid fa-trash delete-icon' onclick='deleteTask($taskId)'></i>";
        echo "<i class='fa $starIconClass star-icon' style='cursor: pointer;' onclick='toggleStar($taskId)'></i>"; // Зірочка        echo "</li>";
    }
} else {
    echo "<li>" . htmlspecialchars($translations['no_tasks']) . "</li>";
}

$stmt->close();
$conn->close();
?>