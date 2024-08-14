<?php
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$profilePhoto = 'default_photo_path.jpg'; // Chemin par défaut de la photo de profil
$prenom = 'Guest';
$nom = '';
$nomInitial = '';

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $profilePhoto = $user['photo_profil'] ?? 'default_photo_path.jpg';
        $prenom = htmlspecialchars($user['prenom']);
        $nom = htmlspecialchars($user['nom']);
    }
}


$pdo = getConnection();

$location = isset($_GET['location']) ? $_GET['location'] : '';
$depart = isset($_GET['depart']) ? $_GET['depart'] : '';
$retour = isset($_GET['retour']) ? $_GET['retour'] : '';

$voitures = [];

if ($location && $depart && $retour) {
    $stmt = $pdo->prepare("
        SELECT v.*
        FROM Vehicules v
        WHERE v.adresse LIKE :location
        AND v.disponibilite = 1
        AND NOT EXISTS (
            SELECT 1 
            FROM reservations r 
            WHERE r.vehicule_id = v.vehicule_id
            AND (
                (r.start_date <= :retour AND r.end_date >= :depart)
            )
        )
    ");
    $stmt->execute([
        'location' => '%' . $location . '%',
        'depart' => $depart,
        'retour' => $retour
    ]);

    $voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruto - Location de voitures</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<header>
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
    </header>
    <nav class="menu">
        <?php if ($isLoggedIn): ?>
            <div class="profile-info">
            <img src="<?php echo $profilePhoto; ?>" alt="Photo de profil" class="profile-photo-small">
            <span><?php echo $prenom . ' ' . $nom . '.'; ?></span>
        </div>
            <a href="MonCompte.php">Compte</a>
            <a href="chat">Messages</a>
            <a href="Hreservation.php">Mes réservations</a>
            <a href="Location.php">Ajouter véhicule</a>
            <div class="separator"></div>
            <a href="/deconnexion">Déconnexion</a>
        <?php else: ?>
            <a href="index.php">Accueil</a>
            <a href="PageConnexion.php">Connexion</a>
            <a href="#">Inscription</a>
            <a href="#">Devenir Hôte</a>
            <div class="separator"></div>
            <a href="#">Support</a>
        <?php endif; ?>
    </nav>

    <main>
        <div class="search-section">
            <div class="search-container">
                <div class="search-field">
                    <label for="location">Lieu</label>
                    <input type="text" id="location" placeholder="Lieu, aéroport, adresse ou hôtel">
                </div>
                <div class="search-field">
                    <label for="depart">Départ</label>
                    <input type="date" id="depart" value="2024-08-20">
                </div>
                <div class="search-field">
                    <label for="depart-time">Heure de départ</label>
                    <input type="time" id="depart-time" value="10:00">
                </div>
                <div class="search-field">
                    <label for="retour">Retour</label>
                    <input type="date" id="retour" value="2024-08-27">
                </div>
                <div class="search-field">
                    <label for="retour-time">Heure de retour</label>
                    <input type="time" id="retour-time" value="10:00">
                </div>
                <div class="search-button-container">
                    <button class="search-button" onclick="searchCars()">Rechercher des voitures</button>
                </div>
            </div>
        </div>
        <div class="filters-results-container">
            <div class="filters">
                <button class="filter-button" data-filter="sort">Ordre de tri</button>
                <button class="filter-button" data-filter="collections">Collections</button>
                <button class="filter-button" data-filter="pickup">Toutes les options de prise en charge</button>
                <button class="filter-button" data-filter="price">Prix par jour</button>
                <button class="filter-button" data-filter="more">Plus de filtres</button>
                <div id="sort" class="filter-content">
                    <p>Pertinence</p>
                    <p>Prix par jour : faible à élevé</p>
                    <p>Prix par jour : élevé à faible</p>
                    <p>Distance</p>
                    <button class="filter-reset">Réinitialiser</button>
                    <button class="filter-show">Afficher 200+ résultats</button>
                </div>
                <div id="price" class="filter-content">
                    <p>10$ - 500$+/jour</p>
                    <input type="range" min="10" max="500">
                    <button class="filter-reset">Réinitialiser</button>
                    <button class="filter-show">Afficher 200+ résultats</button>
                </div>
                <div id="more" class="filter-content">
                    <div>
                        <h3>Type de véhicule</h3>
                        <button>Voitures</button>
                        <button>VUS</button>
                        <button>Minifourgonnettes</button>
                        <button>Camionnettes</button>
                        <button>Fourgonnettes</button>
                    </div>
                    <div>
                        <h3>Caractéristiques du véhicule</h3>
                        <label>Marque</label>
                        <select>
                            <option>- Sélectionner -</option>
                        </select>
                        <label>Toutes les années</label>
                        <input type="range" min="2000" max="2024">
                        <label>Nombre de sièges</label>
                        <select>
                            <option>- Sélectionner -</option>
                        </select>
                    </div>
                    <button class="filter-show">Afficher 200+ résultats</button>
                </div>
            </div>
            <div class="results" id="results">
                <?php foreach ($voitures as $index => $voiture): ?>
                    <div class="result-item" id="car-<?= $index ?>" onclick="showCarDetails(<?= $voiture['vehicule_id'] ?>)">
                        <img src="<?= htmlspecialchars(json_decode($voiture['photos'])[0]) ?>" alt="<?= htmlspecialchars($voiture['marque']) ?>" class="result-image">
                        <div class="result-details">
                            <h3><?= htmlspecialchars($voiture['marque']) ?> <?= htmlspecialchars($voiture['modele']) ?></h3>
                            <p><?= htmlspecialchars($voiture['adresse']) ?></p>
                            <p><?= htmlspecialchars($voiture['prix_quotidien']) ?> $/jour</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul class="footer-navigation">
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="PageConnexion.html">Connexion</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Devenir Hôte</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li>Adresse: 123 Rue de la Location, Ville, Pays</li>
                    <li>Téléphone: +1 (514)-000-0000   Email: contact@mayar.com</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Suivez-nous</h3>
                <ul class="social-media">
                    <li><a href="#"><img src="image/facebook-icon.png" alt="Facebook"></a></li>
                    <li><a href="#"><img src="image/Twitter-logo-black.png" alt="Twitter"></a></li>
                    <li><a href="#"><img src="image/Instagram-icon.png.webp" alt="Instagram"></a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Informations légales</h3>
                <ul>
                    <li><a href="#">Termes de service</a></li>
                    <li><a href="#">Politique de confidentialité</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Mayar. Tous droits réservés.</p>
        </div>
    </footer>
    <script>
        const cars = <?php echo json_encode($voitures); ?>;
    </script>
    <script src="index.js"></script>
</body>
</html>
