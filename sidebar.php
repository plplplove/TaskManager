<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="menu-icon" onclick="toggleSidebar()">
  <i class="fa-solid fa-bars"></i>
</div>
<aside id="sidebar">
  <img src="img/logo.png" alt="logo">

  <a href="user_home.php" class="<?php echo $currentPage === 'user_home.php' ? 'active' : ''; ?>">
    <i class="fa-solid fa-user"></i>
    <?php echo htmlspecialchars($translations['my_account']); ?>
  </a>

  <a href="startask.php" class="<?php echo $currentPage === 'startask.php' ? 'active' : ''; ?>">
    <i class="fa-solid fa-star"></i>
    <?php echo htmlspecialchars($translations['star_tasks']); ?>
  </a>

  <a href="tasks.php" class="<?php echo $currentPage === 'tasks.php' ? 'active' : ''; ?>">
    <i class="fa-solid fa-list"></i>
    <?php echo htmlspecialchars($translations['tasks']); ?>
  </a>

  <a href="calendar.php" class="<?php echo $currentPage === 'calendar.php' ? 'active' : ''; ?>">
    <i class="fa-solid fa-calendar"></i>
    <?php echo htmlspecialchars($translations['calendar']); ?>
  </a>

  <a href="logout.php" class="<?php echo $currentPage === 'logout.php' ? 'active' : ''; ?>">
    <i class="fa-solid fa-right-from-bracket"></i>
    <?php echo htmlspecialchars($translations['log_out']); ?>
  </a>

  <div class="language-selector">
    <label for="language-select">
      <i class="fa-solid fa-globe"></i>
    </label>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="lang" onchange="this.form.submit()">
        <option value="en" <?php echo $lang === 'en' ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['language_english']); ?></option>
        <option value="pl" <?php echo $lang === 'pl' ? 'selected' : ''; ?>><?php echo htmlspecialchars($translations['language_polish']); ?></option>
      </select>
    </form>
  </div>

  <div class="theme-toggle">
    <label for="theme-switch">
      <i class="fa-solid fa-sun"></i>
      <i class="fa-solid fa-moon"></i>
    </label>
    <input type="checkbox" id="theme-switch">
  </div>
</aside>