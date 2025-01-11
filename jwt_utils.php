<?php

class JWTUtils {
    private static $secretKey = 'your_secret_key_here';
    private static $tokenExpiration = 3600;
    private static $refreshTokenExpiration = 604800;

    public static function generateToken($userData, $isRefreshToken = false) {
        $issuedAt = time();
        $expire = $issuedAt + ($isRefreshToken ? self::$refreshTokenExpiration : self::$tokenExpiration);

        $payload = array(
            "iat" => $issuedAt,
            "exp" => $expire,
            "data" => $userData,
            "type" => $isRefreshToken ? 'refresh' : 'access'
        );

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function validateToken($token) {
        try {
            $tokenParts = explode('.', $token);
            if (count($tokenParts) != 3) {
                return false;
            }

            list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $tokenParts;
            
            $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlSignature));
            $validSignature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secretKey, true);
            
            if ($signature !== $validSignature) {
                return false;
            }

            $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);
            
            if (!isset($payload['exp']) || $payload['exp'] < time()) {
                return false;
            }

            return $payload;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getTokenExpiration($token) {
        $payload = self::validateToken($token);
        if ($payload && isset($payload['exp'])) {
            return $payload['exp'] - time();
        }
        return 0;
    }

    public static function getUserData($token) {
        $payload = self::validateToken($token);
        if ($payload && isset($payload['data'])) {
            return $payload['data'];
        }
        return null;
    }
}
