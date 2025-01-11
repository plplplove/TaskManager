<?php
require_once 'jwt_utils.php';

header('Content-Type: application/json');

if (!isset($_COOKIE['jwt'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No token provided']);
    exit();
}

$token = $_COOKIE['jwt'];
$payload = JWTUtils::validateToken($token);

if ($payload === false) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid token']);
    exit();
}

if (isset($payload['exp']) && ($payload['exp'] - time() < 1800)) {
    $newToken = JWTUtils::generateToken($payload['data']);
    setcookie('jwt', $newToken, time() + 3600, '/', '', true, true);
    echo json_encode(['message' => 'Token refreshed']);
} else {
    echo json_encode(['message' => 'Token still valid']);
}
?>
