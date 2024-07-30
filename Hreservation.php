<?php
require_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: PageConnexion.php');
    exit();
}

$userId = $_SESSION['user_id'];
$pdo = getConnection();
$stmt = $pdo->prepare("
    SELECT r.*, v.marque, v.modele, v.photos 
    FROM reservations r
    JOIN Vehicules v ON r.vehicule_id = v.vehicule_id
    WHERE r.user_id = :user_id
");
$stmt->execute(['user_id' => $userId]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$isLoggedIn = isset($_SESSION['user_id']);
$profilePhoto = $isLoggedIn ? ($_SESSION['photo_profil'] ?? 'image/default_photo_path.jpg') : 'image/default_photo_path.jpg';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Réservations</title>
    <link rel="stylesheet" href="Hreservation.css">
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
            <nav class="menu" id="menu">
                <?php if ($isLoggedIn): ?>
                    <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Photo de profil" class="profile-photo">
                    <a href="Compte.php">Compte</a>
                    <a href="Messages.php">Messages</a>
                    <a href="Reservations.php">Mes réservations</a>
                    <a href="EnregistrerVehicule.php">Ajouter véhicule</a>
                    <div class="separator"></div>
                    <a href="/deconnexion">Déconnexion</a>
                <?php else: ?>
                    <a href="PageConnexion.php">Connexion</a>
                    <a href="PageInscription.php">Inscription</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="container">
            <h1>Historique des Réservations</h1>
            <div id="reservations-container">
                <?php if (count($reservations) > 0): ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <div class="reservation">
                            <div class="reservation-details">
                                <h2><?php echo htmlspecialchars($reservation['marque'] . ' ' . $reservation['modele']); ?></h2>
                                <p>Du <?php echo htmlspecialchars($reservation['start_date']); ?> au <?php echo htmlspecialchars($reservation['end_date']); ?></p>
                                <?php if (!empty($reservation['cancel_date'])): ?>
                                    <p>Annulée le <?php echo htmlspecialchars($reservation['cancel_date']); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="reservation-image">
                                <?php
                                $photos = json_decode($reservation['photos'], true);
                                $photoUrl = !empty($photos) && isset($photos[0]) ? htmlspecialchars($photos[0]) : 'path/to/default/image.jpg';
                                ?>
                                <img src="<?php echo $photoUrl; ?>" alt="<?php echo htmlspecialchars($reservation['marque'] . ' ' . $reservation['modele']); ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune réservation</p>
                <?php endif; ?>
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
    <script src="Hreservation.js"></script>
</body>
</html>
