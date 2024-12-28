<?php
session_start();
include 'connect.php';

// Якщо користувача не авторизовано (не задано email у сесії) — виходимо:
if (!isset($_SESSION['email'])) {
    echo "You are not authorized.";
    exit();
}

$user_email = $_SESSION['email'];

// Якщо передано GET-параметр 'search', використаємо його для пошуку (LIKE '%...%')
// Якщо не передано — просто шукаємо все (LIKE '%')
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Готуємо SQL-запит (пошук по task_text)
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

// Якщо завдання знайдено
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        // ID завдання
        $taskId = $row['id'];

        // Текст завдання
        // Використовуємо htmlspecialchars() для безпеки
        $taskText = htmlspecialchars($row['task_text'], ENT_QUOTES);

        // Дата у форматі YYYY-MM-DD (для поля date в модальному вікні)
        $taskDate = date("Y-m-d", strtotime($row['task_date']));

        // Чи виконане?
        $isCompleted = $row['is_completed'] ? true : false;

        // Чи відзначене зіркою?
        $isStarred = $row['is_starred'] ? true : false;

        // Класи для відображення у CSS
        $completedClass = $isCompleted ? 'completed' : '';
        $starredClass   = $isStarred ? 'starred' : '';

        // Значок для «зірки» (Font Awesome)
        // Можна використати fa-star / fa-star-o або fa-regular / fa-solid відповідно до версії FA
        $starIconClass  = $isStarred ? 'fa-star' : 'fa-star-o';

        // Відмітка (checkbox) — якщо виконане
        $checked = $isCompleted ? 'checked' : '';

        // Форматуємо дату для відображення (наприклад, "December 30, 2024")
        $formattedDate = date("F j, Y", strtotime($row['task_date']));

        // Виводимо один елемент списку
        echo "<li class='task-item $completedClass $starredClass'>";
        
        // Чекбокс
        echo "<input type='checkbox' $checked onclick='toggleTask($taskId, this.checked)'>";
        
        // Текст завдання
        echo "<span class='task-text'>$taskText</span>";
        
        // Відформатована дата
        echo "<span class='task-date'>$formattedDate</span>";

        // Іконка «зірка» для перемикання обраного завдання
        echo "<i class='fa $starIconClass' style='cursor:pointer' onclick='toggleStar($taskId)'></i>";

        // Іконка редагування
        // Зверніть увагу на addslashes(), щоб уникнути проблем із лапками в JS
        echo "<i class='fa-solid fa-pen edit-icon' 
                 onclick='openEditModal($taskId, \"" . addslashes($row['task_text']) . "\", \"$taskDate\")'>
              </i>";

        // Іконка видалення
        echo "<i class='fa-solid fa-trash delete-icon' onclick='deleteTask($taskId)'></i>";

        echo "</li>";
    }
    echo "</ul>";
} else {
    // Якщо завдань у БД немає
    echo "<li>You have not added any tasks yet.</li>";
}

$stmt->close();
$conn->close();
?>
