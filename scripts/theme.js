document.addEventListener("DOMContentLoaded", function () {
    const themeSwitch = document.getElementById("theme-switch");
    const sunIcon = document.querySelector(".fa-sun");
    const moonIcon = document.querySelector(".fa-moon");

    // Завантаження теми з локального сховища
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-theme");
        themeSwitch.checked = true;
        moonIcon.style.display = "inline";
        sunIcon.style.display = "none";
    } else {
        moonIcon.style.display = "none";
        sunIcon.style.display = "inline";
    }

    // Перемикач теми
    themeSwitch.addEventListener("change", function () {
        if (themeSwitch.checked) {
            document.body.classList.add("dark-theme");
            localStorage.setItem("theme", "dark");
            moonIcon.style.display = "inline";
            sunIcon.style.display = "none";
        } else {
            document.body.classList.remove("dark-theme");
            localStorage.setItem("theme", "light");
            moonIcon.style.display = "none";
            sunIcon.style.display = "inline";
        }
    });
});