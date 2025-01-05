<?php
session_start();
include 'connect.php';
include_once __DIR__ . '/lang/language_handler.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];
$query = "SELECT id, task_text, task_date, is_completed FROM tasks WHERE user_email = ? AND is_starred = 1 ORDER BY task_date DESC";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die($translations['error_query_preparation']); // Використання перекладу
}

$stmt->bind_param("s", $user_email);
$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    die($translations['error_getting_results']); // Використання перекладу
}
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/logo_icon.png">
  <title><?php echo htmlspecialchars($translations['title']); ?></title>
  <link rel="stylesheet" href="styles/startasks_style.css">
  <link rel="stylesheet" href="styles/sidebar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
  <script defer src="scripts/startask_script.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      flatpickr("#edit-task-date", {
        dateFormat: "Y-m-d",
        minDate: "today",
      });
    });
  </script>
</head>

<body>
  <!-- <div class="menu-icon" onclick="toggleSidebar()">
    <i class="fa-solid fa-bars"></i>
  </div> -->
  <?php include_once __DIR__ . '/sidebar.php'; ?>
  <div class="account-info" id="starred-tasks">
    <h1><?php echo htmlspecialchars($translations['starred_tasks']); ?></h1>
    <div class="task-search">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="search-task" placeholder="<?php echo htmlspecialchars($translations['search_tasks']); ?>" oninput="searchTasks()">
    </div>
    <ul id="starred-tasks-list">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $completedClass = $row['is_completed'] ? 'completed' : '';
          $checked = $row['is_completed'] ? 'checked' : '';
          $taskDate = date($translations['date_format'], strtotime($row['task_date']));
          $taskTextEscaped = json_encode($row['task_text']);
          $taskDateEscaped = json_encode($row['task_date']);

          echo "
            <li class='task-item $completedClass'>
                <input type='checkbox' $checked onclick='toggleTaskCompletion({$row['id']}, this.checked)'>
                <span>{$row['task_text']}</span>
                <span class='task-date'>$taskDate</span>
                <i class='fa-solid fa-pen edit-icon' onclick='openEditModal({$row['id']}, $taskTextEscaped, $taskDateEscaped)'></i>
                <i class='fa-solid fa-trash delete-icon' onclick='deleteTask({$row['id']})'></i>
            </li>";
        }
      } else {
        echo "<li>" . htmlspecialchars($translations['no_starred_tasks']) . "</li>";
      }
      ?>
    </ul>
  </div>

  <!-- Модальне вікно для редагування завдання -->
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
<?php
$stmt->close();
$conn->close();
?>