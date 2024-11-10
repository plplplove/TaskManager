const translations = {
    en: {
        heading: "Build your work’s foundation with tasks",
        paragraph: "Plan, organize, and collaborate on any project with tasks<br> that adapt to any workflow or type of work.",
        button: "Get Started"
    },
    pl: {
        heading: "Zbuduj fundamenty swojej pracy za pomocą zadań",
        paragraph: "Planuj, organizuj i współpracuj nad każdym projektem za pomocą zadań,<br> które dostosowują się do każdego przepływu pracy lub rodzaju pracy.",
        button: "Rozpocznij"
    }
};

let currentLanguage = localStorage.getItem('language') || 'en';

function setLanguage(language) {
    currentLanguage = language;
    localStorage.setItem('language', language); 
    document.getElementById('main-heading').innerHTML = translations[language].heading;
    document.getElementById('main-paragraph').innerHTML = translations[language].paragraph;
    const button = document.getElementById('start-button');
    button.innerHTML = `${translations[language].button} <i class="fa-solid fa-arrow-right"></i>`;
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