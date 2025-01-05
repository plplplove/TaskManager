<?php
include 'lang/language_handler.php';
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/logo_icon.png">
  <title><?php echo htmlspecialchars($translations['title']); ?></title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />

  <script>
    window.lang = "<?php echo $lang; ?>";
    window.translations = {
      editTask: "<?php echo htmlspecialchars($translations['edit_task_title']); ?>", // Переклад "Edit Task"
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

  <link rel="stylesheet" href="styles/calendar_style.css?v=1.0">
  <link rel="stylesheet" href="styles/sidebar.css?v=1.0">
</head>

<body>
  <?php include_once __DIR__ . '/sidebar.php'; ?>

  <div id="calendar"></div>

  <div id="custom-modal" class="modal">
    <div class="modal-content">
      <span class="close-button" onclick="closeModal()">&times;</span>
      <h2 id="modal-title"><?php echo htmlspecialchars($translations['edit_task_title']); ?></h2>
      <input type="text" id="edit-task-text" placeholder="<?php echo htmlspecialchars($translations['edit_task_name']); ?>">
      <div class="modal-actions">
        <button id="save-task-btn" class="modal-btn"><?php echo htmlspecialchars($translations['save_changes']); ?></button>
        <button id="delete-task-btn" class="modal-btn"><?php echo htmlspecialchars($translations['delete_task']); ?></button>
      </div>
    </div>
  </div>

  <script src="scripts/calendar_script.js"></script>
  <script src="scripts/theme.js"></script>
</body>

</html>