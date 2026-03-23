<?php

$host = getenv('DB_HOST') ?: '127.0.0.1';
$db = getenv('DB_DATABASE') ?: 'myapp';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$stmt = $pdo->query('SHOW CREATE TABLE plans');
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo $row['Create Table'] ?? '';

