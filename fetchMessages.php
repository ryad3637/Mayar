<?php
require_once 'config.php';

$conversationId = $_GET['conversationId'] ?? null;

if (!$conversationId) {
    echo json_encode(['error' => 'Conversation ID is missing.']);
    exit();
}

$pdo = getConnection();
$stmt = $pdo->prepare("SELECT m.*, u.prenom AS senderName FROM message m JOIN Utilisateurs u ON m.sender_id = u.user_id WHERE m.conversation_id = :conversationId ORDER BY m.created_at ASC");
$stmt->execute(['conversationId' => $conversationId]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($messages);
?>
