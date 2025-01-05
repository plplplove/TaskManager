<?php
include_once __DIR__ . '/lang/language_handler.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/logo_icon.png">
  <title><?php echo $langData['title']; ?></title>
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
    document.addEventListener("DOMContentLoaded", function() {
      flatpickr("#task-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
      });
    });

    document.addEventListener("DOMContentLoaded", function() {
      flatpickr("#edit-task-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
      });
    });
  </script>
</head>

<body>
  <?php include_once __DIR__ . '/sidebar.php'; ?>
  
  <div class="todo-list">
    <h2><?php echo htmlspecialchars($translations['my_tasks']); ?></h2>
    <div class="task-input">
      <input type="text" id="new-task" placeholder="<?php echo htmlspecialchars($translations['enter_task']); ?>">
      <input type="date" id="task-date" placeholder="<?php echo htmlspecialchars($translations['select_due_date']); ?>">
      <button onclick="addTask()"><?php echo htmlspecialchars($translations['add_task']); ?></button>
    </div>
    <div class="task-search">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="search-task" placeholder="<?php echo htmlspecialchars($translations['search_tasks']); ?>" oninput="searchTasks()">
    </div>
    <ul id="tasks-container">
      
    </ul>
  </div>
  <div id="edit-modal" class="modal" style="display:none">
    <div class="modal-content">
      <span class="close" onclick="closeEditModal()">&times;</span>
      <h2><?php echo htmlspecialchars($translations['edit_task']); ?></h2>
      <input type="hidden" id="edit-task-id">
      <label for="edit-task-text"><?php echo htmlspecialchars($translations['task_name']); ?></label>
      <input type="text" id="edit-task-text" placeholder="<?php echo htmlspecialchars($translations['enter_new_task_name']); ?>">
      <label for="edit-task-date"><?php echo htmlspecialchars($translations['task_date']); ?></label>
      <input type="date" id="edit-task-date" placeholder="<?php echo htmlspecialchars($translations['select_task_date']); ?>">
      <button onclick="saveTaskEdit()"><?php echo htmlspecialchars($translations['save_changes']); ?></button>
    </div>
  </div>
  <script src="scripts/theme.js"></script>
</body>

</html>