<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('620414729244-hejig77caguugme1t00mjthn5cpuh7h6.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/taskmanager/google_callback.php');
$client->addScope('email');
$client->addScope('profile');

if (!isset($_GET['code'])) {
    // Якщо користувач ще не авторизований, створюємо URL для авторизації
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit();
} else {
    // Якщо отримано код авторизації, обробляємо його
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    if (isset($token['error'])) {
        // Якщо виникла помилка, повертаємося на сторінку логіну
        header('Location: login.php');
        exit();
    }

    // Отримуємо інформацію про користувача
    $google_service = new Google_Service_Oauth2($client);
    $userInfo = $google_service->userinfo->get();

    // Зберігаємо інформацію в сесію
    $_SESSION['email'] = $userInfo->email;
    $_SESSION['name'] = $userInfo->name;

    // Перенаправляємо на сторінку профілю
    header('Location: user_home.php');
    exit();
}
?>