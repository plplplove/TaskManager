<?php
session_start(); // Стартуємо сесію
session_unset(); // Видаляємо всі змінні сесії
session_destroy(); // Знищуємо всі дані сесії

// Видаляємо JWT токен з кук
setcookie('jwt', '', time() - 3600, '/', '', true, true);

header('Location: login.php'); // Перенаправляємо на сторінку входу
exit();