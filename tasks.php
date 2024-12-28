<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/logo_icon.png">
  <title>UpNextt</title>
  <link rel="stylesheet" href="styles/tasks_style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap"
    rel="stylesheet">
  <script defer src="scripts/tasks_script.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      flatpickr("#task-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
      });
    });

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
    <a href="user_home.php">
      <i class="fa-solid fa-user"></i>
      My Account
    </a>
    <a href="star task.php">
      <i class="fa-solid fa-star"></i>
      Start Tasks
    </a>
    <a href="tasks.php" class="active">
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
  <div class="todo-list">
    <h2>My Tasks</h2>
    <div class="task-input">
      <input type="text" id="new-task" placeholder="Enter a new task">
      <input type="date" id="task-date" placeholder="Select due date">
      <button onclick="addTask()">Add Task</button>
    </div>
    <div class="task-search">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="search-task" placeholder="Search tasks" oninput="searchTasks()">
    </div>
    <ul id="tasks-container">
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