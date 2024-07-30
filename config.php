<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getConnection() {
    $host = 'database';
    $dbname = 'Mayar';
    $username = 'root';
    $password = 'tiger';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
?>
