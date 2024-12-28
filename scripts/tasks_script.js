function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const menuIcon = document.querySelector(".menu-icon i");
  
    sidebar.classList.toggle("visible");
    sidebar.classList.toggle("hidden");
  
    if (sidebar.classList.contains("visible")) {
      menuIcon.classList.replace("fa-bars", "fa-xmark");
    } else {
      menuIcon.classList.replace("fa-xmark", "fa-bars");
    }
  }

function loadTasks() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "load_tasks.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            console.log("AJAX response received"); 
            if (xhr.status === 200) {
                console.log("Tasks loaded successfully");
                document.getElementById('tasks-container').innerHTML = xhr.responseText;
            } else {
                console.error("Error loading tasks: ", xhr.statusText); 
            }
        }
    };
    xhr.send();
}

function toggleStar(taskId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "star_task.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            loadTasks();  
        }
    };
    xhr.send("id=" + taskId);
}

function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_task.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Task deleted successfully");
                loadTasks(); 
                location.reload(); 
            }
        };
        xhr.send("id=" + taskId);
    }
}

function toggleTask(taskId, isCompleted) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "toggle_task.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Task completion status updated successfully");
            location.reload();
        }
    };
    xhr.send("id=" + taskId + "&is_completed=" + (isCompleted ? 1 : 0));
}

function searchTasks() {
    const searchText = document.getElementById('search-task').value.toLowerCase();
    const tasks = document.querySelectorAll('#tasks-container li');
    
    tasks.forEach(task => {
      // Беремо саме текст завдання:
      const textElement = task.querySelector('.task-text'); 
      const textContent = textElement ? textElement.textContent.toLowerCase() : '';
  
      // Визначаємо, чи відображати поточний <li>:
      if (textContent.includes(searchText)) {
        task.style.display = '';
      } else {
        task.style.display = 'none';
      }
    });
  }
  

function addTask() {
    const taskText = document.getElementById('new-task').value;
    const taskDate = document.getElementById('task-date').value;

    if (!taskText.trim()) return alert("Task cannot be empty!");
    if (!taskDate) return alert("Please select a date!");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "add_task.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            loadTasks(); 
            document.getElementById('new-task').value = "";
            document.getElementById('task-date').value = "";
        }
    };
    xhr.send("task_text=" + encodeURIComponent(taskText) + "&task_date=" + encodeURIComponent(taskDate));
}

function editTask(id, currentText, currentDate) {
    const newText = prompt("Enter new task text:", currentText);
    const newDate = prompt("Enter a new date (YYYY-MM-DD):", currentDate);

    if (newText && newDate) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_task.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                loadTasks();
            }
        };
        xhr.send("id=" + id + "&task_text=" + encodeURIComponent(newText) + "&task_date=" + encodeURIComponent(newDate));
    }
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

    if (!newText.trim()) return alert("The task text cannot be empty.!");
    if (!newDate) return alert("Select a date!");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_task.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            loadTasks();
            closeEditModal();
        }
    };
    xhr.send("id=" + id + "&task_text=" + encodeURIComponent(newText) + "&task_date=" + encodeURIComponent(newDate));
}
window.onload = () => loadTasks();