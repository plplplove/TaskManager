<?php
session_start();
include 'connect.php';
include_once __DIR__ . '/lang/language_handler.php';

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
<html lang="<?php echo htmlspecialchars($lang); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/logo_icon.png">
  <title><?php echo htmlspecialchars($translations['title']); ?></title>
  <link rel="stylesheet" href="styles/userhome_style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>

<body>
  <?php include_once __DIR__ . '/sidebar.php'; ?>

  <div class="account-info" id="user-info">
    <h1><?php echo htmlspecialchars($translations['account_information']); ?></h1>
    <h2><?php echo htmlspecialchars($translations['basic_info']); ?></h2>
    <div class="basic-info">
      <p class="header"><?php echo htmlspecialchars($translations['username']); ?></p>
      <div class="field-container">
        <p id="username-display"><?php echo htmlspecialchars($username); ?></p>
        <input type="text" id="username-input" value="<?php echo htmlspecialchars($username); ?>" style="display:none;">
        <button id="username-save" onclick="saveChanges('username')" style="display:none;"><?php echo htmlspecialchars($translations['save']); ?></button>
        <i class="fa-solid fa-pen edit-icon" onclick="enableEdit('username')"></i>
      </div>
    </div>
    <div class="basic-info">
      <p class="header"><?php echo htmlspecialchars($translations['email']); ?></p>
      <div class="field-container">
        <p id="email-display"><?php echo htmlspecialchars($email); ?></p>
        <input type="text" id="email-input" value="<?php echo htmlspecialchars($email); ?>" style="display:none;">
        <button id="email-save" onclick="saveChanges('email')" style="display:none;"><?php echo htmlspecialchars($translations['save']); ?></button>
        <i class="fa-solid fa-pen edit-icon" onclick="enableEdit('email')"></i>
      </div>
    </div>
    <div class="password">
      <p><?php echo htmlspecialchars($translations['change_password']); ?></p>
      <i class="fa-solid fa-pen edit-icon" onclick="openModal()"></i>
    </div>
  </div>
  </div>
  <div id="change-password-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2><?php echo htmlspecialchars($translations['change_password']); ?></h2>
      <label for="old-password"><?php echo htmlspecialchars($translations['old_password']); ?></label>
      <input type="password" id="old-password" required>
      <label for="new-password"><?php echo htmlspecialchars($translations['new_password']); ?></label>
      <input type="password" id="new-password" required>
      <label for="confirm-password"><?php echo htmlspecialchars($translations['confirm_password']); ?></label>
      <input type="password" id="confirm-password" required>
      <button onclick="changePassword()"><?php echo htmlspecialchars($translations['save']); ?></button>
    </div>
  </div>

  <script defer src="scripts/user_home_script.js"></script>
  <script src="scripts/theme.js"></script>
</body>

</html>