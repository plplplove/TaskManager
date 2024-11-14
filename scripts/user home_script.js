
        function enableEdit(field) {
            const display = document.getElementById(field + '-display');
            const input = document.getElementById(field + '-input');
            const saveButton = document.getElementById(field + '-save');
            display.style.display = 'none';
            input.style.display = 'inline';
            saveButton.style.display = 'inline';
        }
        
        function saveChanges(field) {
            const newValue = document.getElementById(field + '-input').value;
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_user_info.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById(field + '-display').textContent = newValue;
                    document.getElementById(field + '-display').style.display = 'inline';
                    document.getElementById(field + '-input').style.display = 'none';
                    document.getElementById(field + '-save').style.display = 'none';
                }
            };
            xhr.send("field=" + field + "&value=" + encodeURIComponent(newValue));
        }
        function openModal() {
    document.getElementById('change-password-modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('change-password-modal').style.display = 'none';
}

function changePassword() {
    const oldPassword = document.getElementById('old-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword !== confirmPassword) {
        alert("New passwords do not match!");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "change_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            closeModal();
        }
    };
    xhr.send("old_password=" + encodeURIComponent(oldPassword) + "&new_password=" + encodeURIComponent(newPassword));
}