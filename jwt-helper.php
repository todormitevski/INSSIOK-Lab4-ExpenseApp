<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function createJWT($userId, $username): string
{
    $secretKey = $_ENV["JWT_TOKEN"];

    if (!$secretKey) {
        throw new Exception("JWT_TOKEN not found in environment variables.");
    }

    $payload = [
        'iss' => 'your-website.com', // token issuer
        'aud' => 'your-website.com', // token audience
        'iat' => time(),             // time of issuing (timestamp)
        'exp' => time() + 3600,      // expiration time (1h)
        'userId' => $userId,
        'username' => $username,
    ];

    return Firebase\JWT\JWT::encode($payload, $secretKey, 'HS256');  // Враќање на генерираниот токен
}

function decodeJWT($jwt)
{
    try {
        $jwtSecret = $_ENV["JWT_TOKEN"];
        return JWT::decode($jwt, new Key($jwtSecret, 'HS256'));  // Декодирање на токенот со користење на клучот
    } catch (Exception $e) {
        return null;
    }
}
