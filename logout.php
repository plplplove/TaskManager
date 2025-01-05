<?php
session_start(); // Стартуємо сесію
session_unset(); // Видаляємо всі змінні сесії
session_destroy(); // Знищуємо всі дані сесії
header('Location: login.php'); // Перенаправляємо на сторінку входу
exit();