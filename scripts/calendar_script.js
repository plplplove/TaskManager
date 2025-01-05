document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");
  let currentEventId = null;

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    locale: window.lang, 
    events: "load_calendar_tasks.php",
    eventClick: function (info) {
      const modal = document.getElementById("custom-modal");
      const editTaskInput = document.getElementById("edit-task-text");
      const modalTitle = document.getElementById("modal-title");

      currentEventId = info.event.id;

      editTaskInput.value = info.event.title;
      modalTitle.textContent = window.translations.editTask;

      modal.style.display = "flex";
    },
  });
  calendar.render();

  document
    .getElementById("save-task-btn")
    .addEventListener("click", function () {
      const editTaskInput = document.getElementById("edit-task-text");
      const newTaskText = editTaskInput ? editTaskInput.value.trim() : "";

      fetch("update_task.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${currentEventId}&task_text=${encodeURIComponent(
          newTaskText
        )}`,
      })
        .then((response) => response.text())
        .then((result) => {
          console.log("Server response:", result);
          if (result === "success") {
            calendar.refetchEvents();
            closeModal();
          } else {
            alert("Error updating task");
          }
        })
        .catch((error) => console.error("Error:", error));
    });

  document
    .getElementById("delete-task-btn")
    .addEventListener("click", function () {

      fetch("delete_task.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${currentEventId}`,
      })
        .then((response) => response.text())
        .then((result) => {
          console.log("Server response:", result);
          if (result === "success") {
            calendar.refetchEvents();
            closeModal();
          } else {
            alert("Error deleting task");
          }
        })
        .catch((error) => console.error("Error:", error));
    });

  document.addEventListener("click", function (event) {
    const modal = document.getElementById("custom-modal");
    if (event.target === modal) {
      closeModal();
    }
  });

  window.closeModal = function () {
    const modal = document.getElementById("custom-modal");
    modal.style.display = "none";
  };
});



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