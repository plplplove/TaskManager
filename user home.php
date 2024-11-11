<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php"); 
    exit();
}
$email = $_SESSION['email'];
$query = "SELECT username, email FROM users WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); 
    $username = $user['username'];
    $email = $user['email'];
} else {
    echo "User is not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/logo_icon.png">
    <title>UpNextt</title>
    <link rel="stylesheet" href="styles/userhome_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    <script>
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
    </script>
</head>
<body>
  <aside>
    <img src="img/logo.png" alt="logo">
    <a href="#" class="active">
      <i class="fa-solid fa-user"></i>
      My Account
    </a>
    <a href="#">
      <i class="fa-solid fa-star"></i>
      Start Tasks
    </a>
    <a href="#">
      <i class="fa-solid fa-list"></i>
      Tasks
    </a>
    <a href="#">
      <i class="fa-solid fa-calendar"></i>
      Calendar
    </a>
    <a href="#">
      <i class="fa-solid fa-globe"></i>
      Language
    </a>
  </aside>
<div class="account-info" id="user-info">
  <h1>Account Information</h1>
  <h2>Basic Info</h2>
  <div class="basic-info">
  <p class="header">UserName</p>
  <div class="field-container">
      <p id="username-display"><?php echo htmlspecialchars($username); ?></p>
      <input type="text" id="username-input" value="<?php echo htmlspecialchars($username); ?>" style="display:none;">
      <button id="username-save" onclick="saveChanges('username')" style="display:none;">Save</button>
      <i class="fa-solid fa-pen edit-icon" onclick="enableEdit('username')"></i>  
  </div>
</div>
<div class="basic-info">
  <p class="header">Email</p>
  <div class="field-container">
      <p id="email-display"><?php echo htmlspecialchars($email); ?></p>
      <input type="text" id="email-input" value="<?php echo htmlspecialchars($email); ?>" style="display:none;">
      <button id="email-save" onclick="saveChanges('email')" style="display:none;">Save</button>
      <i class="fa-solid fa-pen edit-icon" onclick="enableEdit('email')"></i>
  </div>
</div>
<div class="password">
  <p>Change password</p>
  <i class="fa-solid fa-pen edit-icon" onclick="openModal()"></i>
</div>
</div>
</div>
<div id="change-password-modal" class="modal" style="display: none;">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Change Password</h2>
    <label for="old-password">Old Password:</label>
    <input type="password" id="old-password" required>
    <label for="new-password">New Password:</label>
    <input type="password" id="new-password" required>
    <label for="confirm-password">Confirm New Password:</label>
    <input type="password" id="confirm-password" required>
    <button onclick="changePassword()">Save</button>
  </div>
</div>
</body>
</html>