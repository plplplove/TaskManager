<?php
require_once 'jwt_utils.php';

function isAuthenticated() {
    if (!isset($_COOKIE['jwt'])) {
        return false;
    }

    $token = $_COOKIE['jwt'];
    $payload = JWTUtils::validateToken($token);
    
    return $payload !== false;
}

if (!isAuthenticated()) {
    header('Location: login.php');
    exit();
}
?>
