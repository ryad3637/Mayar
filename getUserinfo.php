<?php
require_once 'config.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT user_id, CONCAT(prenom, ' ', nom) AS userName FROM Utilisateurs WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['userId' => $user['user_id'], 'userName' => $user['userName']]);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}
?>
