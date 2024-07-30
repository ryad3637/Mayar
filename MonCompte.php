<?php
require_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: PageConnexion.php');
    exit();
}

// Fetch user information
$userId = $_SESSION['user_id'];
$pdo = getConnection();
$stmt = $pdo->prepare("SELECT * FROM  Utilisateurs WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Définir la photo de profil
$profilePhoto = $user['photo_profil'] ?? 'default_photo_path.jpg';
$prenom = $user['prenom'];
$nom = $user['nom'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte</title>
    <link rel="stylesheet" href="MonCompte.css">
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <img src="image/LOGO-5.png" alt="Logo de MAYAR">
            </div>
            <button class="menu-button" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>
        </div>
        <nav class="menu" id="menu">
            <div class="profile-info">
                <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Photo de profil" class="profile-photo-small">
                <span><?php echo htmlspecialchars($user['prenom']) . ' ' . strtoupper(substr($user['nom'], 0, 1)) . '.'; ?></span>
                
            </div>
            <a href="Compte.php">Compte</a>
            <a href="Messages.php">Messages</a>
            <a href="Reservations.php">Mes réservations</a>
            <a href="EnregistrerVehicule.php">Ajouter véhicule</a>
            <div class="separator"></div>
            <a href="/deconnexion">Déconnexion</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h1>Compte</h1>
            <div class="profile-header">
                <div class="profile-photo-container">
                    <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Photo de profil" class="profile-photo-large">
                </div>
            </div>
            <div class="profile-section">
                <h2>Ajouter photo de profil</h2>
                <form id="photoForm" action="uploadPhotos.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profile_photo" required>
                    <button type="submit">Mettre à jour</button>
                </form>
                <div id="photoMessage"></div>
            </div>
            <div class="profile-section">
                <h2>Ajouter adresse de facturation</h2>
                <form id="addressForm" action="updateAddress.php" method="POST">
                    <textarea name="address" rows="3"><?php echo htmlspecialchars($user['adresse']); ?></textarea>
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
            <div class="profile-section">
                <h2>Numéro de téléphone</h2>
                <form id="phoneForm" action="updatePhone.php" method="POST">
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['numero_telephone']); ?>">
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
            <div class="profile-section">
                <h2>Email</h2>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Connexion</a></li>
                    <li><a href="#">Devenir Hôte</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li>Adresse: 123 Rue de la Location, Ville, Pays</li>
                    <li>Téléphone: +1 234 567 890</li>
                    <li>Email: contact@mayar.com</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Suivez-nous</h3>
                <ul class="social-media">
                    <li><a href="#"><img src="image/facebook-icon.png" alt="Facebook"></a></li>
                    <li><a href="#"><img src="image/twitter-icon.png" alt="Twitter"></a></li>
                    <li><a href="#"><img src="image/instagram-icon.png" alt="Instagram"></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Mayar. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="MonCompte.js"></script>
</body>
</html>
