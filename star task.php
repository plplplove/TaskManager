<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php"); 
    exit();
}

$user_email = $_SESSION['email'];
$query = "SELECT id, task_text, task_date, is_completed FROM tasks WHERE user_email = ? AND is_starred = 1 ORDER BY task_date DESC";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Request preparation error: " . $conn->error);
}

$stmt->bind_param("s", $user_email);
$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    die("Error getting results: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/logo_icon.png">
    <title>UpNextt</title>
    <link rel="stylesheet" href="styles/startasks_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <script defer src="scripts/startask_script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      flatpickr("#edit-task-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
      });
    });
  </script>
</head>
<body>
<div class="menu-icon" onclick="toggleSidebar()">
  <i class="fa-solid fa-bars"></i>
</div>
  <aside id="sidebar">
    <img src="img/logo.png" alt="logo">
    <a href="user home.php">
      <i class="fa-solid fa-user"></i>
      My Account
    </a>
    <a href="#" class="active">
      <i class="fa-solid fa-star"></i>
      Start Tasks
    </a>
    <a href="tasks.php">
      <i class="fa-solid fa-list"></i>
      Tasks
    </a>
    <a href="calendar.php">
      <i class="fa-solid fa-calendar"></i>
      Calendar
    </a>
    <a href="#">
      <i class="fa-solid fa-globe"></i>
      Language
    </a>
    <a href="banner.php">
    <i class="fa-solid fa-right-from-bracket"></i>
      Log Out
    </a>
  </aside>
  <div class="account-info" id="starred-tasks">
    <h1>Starred Tasks</h1>
    <div class="task-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="search-task" placeholder="Search tasks" oninput="searchTasks()">
    </div>
    <ul id="starred-tasks-list">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $completedClass = $row['is_completed'] ? 'completed' : '';
            $checked = $row['is_completed'] ? 'checked' : '';
            $taskDate = date("F j, Y", strtotime($row['task_date']));

            echo "
            <li class='task-item $completedClass'>
                <input type='checkbox' $checked onclick='toggleTaskCompletion({$row['id']}, this.checked)'>
                <span>{$row['task_text']}</span>
                <span class='task-date'>$taskDate</span>
                <i class='fa-solid fa-pen edit-icon' onclick='openEditModal({$row['id']}, \"{$row['task_text']}\", \"{$row['task_date']}\")'></i>
            <i class='fa-solid fa-trash delete-icon' onclick='deleteTask({$row['id']})'></i>
                </li>";
        }
    } else {
        echo "<li>No starred tasks found.</li>";
    }
    ?>
</ul>
  </div>
  
  <div id="edit-modal" class="modal" style="display:none">
    <div class="modal-content">
      <span class="close" onclick="closeEditModal()">&times;</span>
      <h2>Edit task</h2>
      <input type="hidden" id="edit-task-id">
      <label for="edit-task-text">Name:</label>
      <input type="text" id="edit-task-text" placeholder="Enter a new task name.">
      <label for="edit-task-date">Date:</label>
      <input type="date" id="edit-task-date" placeholder="Select new date.">
      <button onclick="saveTaskEdit()">Save changes</button>
    </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
