<?php
session_start();
include 'connect.php';


if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
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
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
    
        $taskId = $row['id'];
        $taskText = htmlspecialchars($row['task_text'], ENT_QUOTES);
        $taskDate = date("Y-m-d", strtotime($row['task_date']));


        $isCompleted = $row['is_completed'] ? true : false;


        $isStarred = $row['is_starred'] ? true : false;

        $completedClass = $isCompleted ? 'completed' : '';
        $starredClass   = $isStarred ? 'starred' : '';

        $starIconClass  = $isStarred ? 'fa-star' : 'fa-star-o';

        $checked = $isCompleted ? 'checked' : '';
        $formattedDate = date("F j, Y", strtotime($row['task_date']));

        echo "<li class='task-item $completedClass $starredClass'>";
        

        echo "<input type='checkbox' $checked onclick='toggleTask($taskId, this.checked)'>";
        
        echo "<span class='task-text'>$taskText</span>";
        
        echo "<span class='task-date'>$formattedDate</span>";

        echo "<i class='fa $starIconClass' style='cursor:pointer' onclick='toggleStar($taskId)'></i>";

        echo "<i class='fa-solid fa-pen edit-icon' 
                 onclick='openEditModal($taskId, \"" . addslashes($row['task_text']) . "\", \"$taskDate\")'>
              </i>";

        echo "<i class='fa-solid fa-trash delete-icon' onclick='deleteTask($taskId)'></i>";

        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<li>You have not added any tasks yet.</li>";
}

$stmt->close();
$conn->close();
?>
