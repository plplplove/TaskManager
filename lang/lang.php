<?php
session_start();

if (isset($_GET['lang'])) {
    $language = $_GET['lang'];
    $allowed_languages = ['en', 'pl'];

    if (in_array($language, $allowed_languages)) {
        $_SESSION['lang'] = $language;
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();