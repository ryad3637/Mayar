<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: PageConnexion.php');
    exit();
}

// Récupérer les informations de l'utilisateur connecté
$userId = $_SESSION['user_id'];
$pdo = getConnection();
$stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$profilePhoto = $user['photo_profil'] ?? 'default_photo_path.jpg';
$prenom = $user['prenom'];
$nom = $user['nom'];
$receiverId = $_GET['receiver_id']; // Assurez-vous que cet ID est correctement passé
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat avec <?php echo htmlspecialchars($prenom); ?></title>
    <link rel="stylesheet" href="chat.css">
</head>
<body>
    <div id="chat-container" data-user-id="<?php echo htmlspecialchars($userId); ?>" data-user-name="<?php echo htmlspecialchars($prenom . ' ' . $nom); ?>" data-receiver-id="<?php echo htmlspecialchars($receiverId); ?>">
        <div class="chat-container">
            <div class="chat-header">
                <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Photo de profil" class="profile-photo-small">
                <h2>Chat avec <?php echo htmlspecialchars($prenom . ' ' . $nom); ?></h2>
            </div>
            <div class="chat-messages" id="chat-messages"></div>
            <div class="chat-input">
                <input type="text" id="messageInput" placeholder="Tapez votre message...">
                <button id="sendButton">Envoyer</button>
            </div>
        </div>
    </div>
    <script src="chat.js"></script>
</body>
</html>
