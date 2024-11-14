function searchTasks() {
    const searchText = document.getElementById('search-task').value.toLowerCase();
    const tasks = document.querySelectorAll('#starred-tasks-list li');
    tasks.forEach(task => {
        const taskText = task.textContent.toLowerCase();
        task.style.display = taskText.includes(searchText) ? '' : 'none';
    });
}

function openEditModal(id, currentText, currentDate) {
document.getElementById('edit-task-id').value = id;
document.getElementById('edit-task-text').value = currentText;
document.getElementById('edit-task-date').value = currentDate;
document.getElementById('edit-modal').style.display = 'flex';
}

function closeEditModal() {
document.getElementById('edit-modal').style.display = 'none';
}

function saveTaskEdit() {
const id = document.getElementById('edit-task-id').value;
const newText = document.getElementById('edit-task-text').value;
const newDate = document.getElementById('edit-task-date').value;

if (!newText.trim()) return alert("Текст завдання не може бути порожнім!");
if (!newDate) return alert("Виберіть дату!");

const xhr = new XMLHttpRequest();
xhr.open("POST", "update_task.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        location.reload();
        closeEditModal();
    }
};
xhr.send("id=" + id + "&task_text=" + encodeURIComponent(newText) + "&task_date=" + encodeURIComponent(newDate));
}

function deleteTask(taskId) {
if (confirm("Ви впевнені, що хочете видалити це завдання?")) {
const xhr = new XMLHttpRequest();
xhr.open("POST", "delete_task.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onload = function () {
    if (xhr.status === 200) {
        console.log("Task deleted successfully, reloading page");
        location.reload();
    } else {
        console.error("Error deleting task");
    }
};
xhr.send("id=" + taskId);
}
}

function toggleTaskCompletion(taskId, isCompleted) {
const xhr = new XMLHttpRequest();
xhr.open("POST", "toggle_completion.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        location.reload();
    }
};
xhr.send("id=" + taskId + "&is_completed=" + (isCompleted ? 1 : 0));
}