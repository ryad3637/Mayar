<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['profile_photo'])) {
        echo json_encode(['message' => 'No file uploaded']);
        exit();
    }

    $pdo = getConnection();

    // Get the current user's ID from the session
    $userId = $_SESSION['user_id'];

    // Fetch the current photo path from the database
    $stmt = $pdo->prepare("SELECT photo_profil FROM Utilisateurs WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['message' => 'User not found']);
        exit();
    }

    $currentPhotoPath = $user['photo_profil'];

    // Directory where the photos will be stored
    $targetDir = "uploads/";

    // Ensure the directory exists
    if (!file_exists($targetDir) && !mkdir($targetDir, 0777, true)) {
        echo json_encode(['message' => 'Failed to create upload directory']);
        exit();
    }

    $targetFile = $targetDir . basename($_FILES['profile_photo']['name']);

    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
        // Delete the old photo if it exists
        if ($currentPhotoPath && file_exists($currentPhotoPath)) {
            unlink($currentPhotoPath);
        }

        // Update the database with the new photo path
        $stmt = $pdo->prepare("UPDATE Utilisateurs SET photo_profil = :photo_profil WHERE user_id = :user_id");
        $stmt->execute(['photo_profil' => $targetFile, 'user_id' => $userId]);

        echo json_encode(['message' => 'Photo uploaded successfully', 'filePath' => $targetFile]);
    } else {
        echo json_encode(['message' => 'Failed to upload photo']);
    }
}
?>
