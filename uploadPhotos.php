<?php
// uploadPhotos.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/'; // Assurez-vous que ce répertoire existe et est accessible en écriture
    $filePaths = [];

    if (!is_array($_FILES['photos']['tmp_name'])) {
        echo json_encode(['message' => 'Invalid file input']);
        exit;
    }

    foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['photos']['name'][$key]);
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($tmpName, $filePath)) {
            $filePaths[] = $filePath;
        } else {
            echo json_encode(['message' => 'Erreur lors du téléchargement des photos']);
            exit;
        }
    }

    echo json_encode(['filePaths' => $filePaths]);
}
?>
