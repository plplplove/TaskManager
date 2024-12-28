document.addEventListener("DOMContentLoaded", () => {
    const themeToggleButton = document.getElementById('theme-toggle');
    const logoImage = document.querySelector('.logo'); 

    let currentTheme = localStorage.getItem('theme') || 'light';

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
            themeToggleButton.innerHTML = '<i class="fa-solid fa-moon"></i>';
            logoImage.src = 'img/logo_white.png'; 
        } else {
            document.body.classList.remove('dark-theme');
            themeToggleButton.innerHTML = '<i class="fa-solid fa-sun"></i>';
            logoImage.src = 'img/logo.png'; 
        }
        localStorage.setItem('theme', theme);
    }

    themeToggleButton.addEventListener('click', () => {
        currentTheme = currentTheme === 'light' ? 'dark' : 'light';
        applyTheme(currentTheme);
    });
    applyTheme(currentTheme);
});


const translations = {
    en: {
        signUp: "Sign up",
        login: "Login",
        placeholderUserName: "User name",
        placeholderEmail: "Email",
        placeholderPassword: "Password",
        signUpButton: "Sign up",
        loginButton: "Login"
    },
    pl: {
        signUp: "Zarejestruj się",
        login: "Zaloguj się",
        placeholderUserName: "Nazwa użytkownika",
        placeholderEmail: "Email",
        placeholderPassword: "Hasło",
        signUpButton: "Zarejestruj się",
        loginButton: "Zaloguj się"
    }
};

let currentLanguage = localStorage.getItem('language') || 'en';

function setLanguage(language) {
    currentLanguage = language;
    localStorage.setItem('language', language);
    
    // Sign Up форма
    document.querySelector(".sign-up label").textContent = translations[language].signUp;
    document.querySelector(".sign-up input[name='user']").placeholder = translations[language].placeholderUserName;
    document.querySelector(".sign-up input[name='email']").placeholder = translations[language].placeholderEmail;
    document.querySelector(".sign-up input[name='password']").placeholder = translations[language].placeholderPassword;
    document.querySelector(".signup-btn").textContent = translations[language].signUpButton;
    
    // Login форма
    document.querySelector(".log-in label").textContent = translations[language].login;
    document.querySelector(".log-in input[name='email']").placeholder = translations[language].placeholderEmail;
    document.querySelector(".log-in input[name='password']").placeholder = translations[language].placeholderPassword;
    document.querySelector(".login-btn").textContent = translations[language].loginButton;

    document.body.classList.remove('lang-en', 'lang-pl');
    document.body.classList.add(`lang-${language}`);
}

function toggleLanguage() {
    const newLanguage = currentLanguage === 'en' ? 'pl' : 'en';
    setLanguage(newLanguage);
}

document.getElementById('button-language').addEventListener('click', function(event) {
    event.preventDefault();
    toggleLanguage();
});

setLanguage(currentLanguage);