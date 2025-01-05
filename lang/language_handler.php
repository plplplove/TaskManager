<?php
session_start();

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; 
}

if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'pl'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = $_SESSION['lang'];

$languageFile = __DIR__ . "/languages/{$lang}.php";

if (file_exists($languageFile)) {
    $translations = include $languageFile;
} else {
    die("Language file not found: {$languageFile}");
}
?>
