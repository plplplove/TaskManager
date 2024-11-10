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
    document.querySelector(".sign-up label[for='chk']").innerText = translations[language].signUp;
    document.querySelector(".sign-up input[name='txt']").placeholder = translations[language].placeholderUserName;
    document.querySelector(".sign-up input[name='email']").placeholder = translations[language].placeholderEmail;
    document.querySelector(".sign-up input[name='pswd']").placeholder = translations[language].placeholderPassword;
    document.querySelector(".sign-up button").innerText = translations[language].signUpButton;
    
    document.querySelector(".log-in label[for='chk']").innerText = translations[language].login;
    document.querySelector(".log-in input[name='email']").placeholder = translations[language].placeholderEmail;
    document.querySelector(".log-in input[name='pswd']").placeholder = translations[language].placeholderPassword;
    document.querySelector(".log-in button").innerText = translations[language].loginButton;

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