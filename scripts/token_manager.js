function refreshToken() {
    fetch('token_refresh.php', {
        method: 'POST',
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Token refresh error:', data.error);
            if (data.error === 'Invalid token') {
                window.location.href = 'login.php';
            }
        }
    })
    .catch(error => {
        console.error('Token refresh failed:', error);
    });
}

setInterval(refreshToken, 15 * 60 * 1000);

let activityTimeout;
function handleUserActivity() {
    clearTimeout(activityTimeout);
    activityTimeout = setTimeout(refreshToken, 5 * 60 * 1000);
}

document.addEventListener('mousemove', handleUserActivity);
document.addEventListener('keypress', handleUserActivity);
document.addEventListener('click', handleUserActivity);
document.addEventListener('scroll', handleUserActivity);
