<?php
require_once 'config.php';

session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: PageConnexion.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Récupérer les informations des véhicules de l'utilisateur
$pdo = getConnection();
$stmt = $pdo->prepare("
    SELECT v.*, GROUP_CONCAT(r.start_date, ',', r.end_date SEPARATOR ';') AS reservations
    FROM Vehicules v
    LEFT JOIN reservations r ON v.vehicule_id = r.vehicule_id
    WHERE v.user_id = :user_id
    GROUP BY v.vehicule_id
");
$stmt->execute(['user_id' => $userId]);
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les réservations récentes
$reservationStmt = $pdo->prepare("
    SELECT r.*, v.marque, v.modele, u.nom, u.prenom
    FROM reservations r
    JOIN Vehicules v ON r.vehicule_id = v.vehicule_id
    JOIN Utilisateurs u ON r.user_id = u.user_id
    WHERE v.user_id = :user_id
    ORDER BY r.start_date DESC
");
$reservationStmt->execute(['user_id' => $userId]);
$reservations = $reservationStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Véhicules</title>
    <link rel="stylesheet" href="MonVehicule.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="image/LOGO-3_2.png" alt="Logo">
            </div>
            <button class="menu-button" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>
        </header>
        <nav class="menu">
            <a href="index.php">Accueil</a>
            <a href="PageConnexion.php">Connexion</a>
            <a href="#">Inscription</a>
            <a href="#">Devenir Hôte</a>
            <div class="separator"></div>
            <a href="#">Support</a>
        </nav>
        <main>
            <section class="dashboard">
                <div class="quick-summary">
                    <h2>Résumé Rapide</h2>
                    <div class="summary-item">Véhicules Loués: <span>10</span></div>
                    <div class="summary-item">Véhicules Disponibles: <span>5</span></div>
                    <div class="summary-item">Revenus: <span>$1500</span></div>
                </div>
                <div class="charts">
                    <h2>Statistiques</h2>
                    <canvas id="revenueChart"></canvas>
                </div>
            </section>
            <section class="vehicle-filters">
                <h2>Filtrer les Véhicules</h2>
                <div class="filters">
                    <input type="text" id="search" placeholder="Rechercher par nom...">
                    <select id="vehicleType">
                        <option value="">Tous les types</option>
                        <option value="SUV">SUV</option>
                        <option value="Sedan">Sedan</option>
                        <option value="Coupe">Coupe</option>
                    </select>
                    <a href="EnregistrerVehicule.php" class="add-vehicle-button">Ajouter Véhicule</a>
                </div>
            </section>
            <section class="vehicle-list">
                <h2>Vos Véhicules</h2>
                <div class="card-container" id="vehicleCards">
    <?php foreach ($vehicules as $vehicule): ?>
        <div class="card">
            <button class="calendar-button" data-reservations="<?php echo htmlspecialchars($vehicule['reservations']); ?>">📅</button>
            <div class="image-container">
                <img src="<?php echo htmlspecialchars(json_decode($vehicule['photos'])[0]); ?>" alt="<?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']); ?>">
            </div>
            <h3><?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']); ?></h3>
            <p class="price"><?php echo htmlspecialchars($vehicule['prix_quotidien']); ?> <span>/jour</span></p>
            <p>Type: <?php echo htmlspecialchars($vehicule['style']); ?></p>
            <p>Statut: Disponible</p>
            <div class="card-actions">
            <a href="ModifierVehicule.php?vehicule_id=<?php echo $vehicule['vehicule_id']; ?>">Modifier</a>
                <button>Supprimer</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
                <?php if (count($vehicules) === 0): ?>
                    <div class="no-vehicles-message" id="noVehiclesMessage">
                        <p>Vous n'avez aucun véhicule ajouté. Ajoutez un véhicule maintenant et commencez à gagner de l'argent!</p>
                        <a href="EnregistrerVehicule.php" class="add-vehicle-button">Ajouter Véhicule</a>
                    </div>
                <?php endif; ?>
            </section>
            <section class="recent-bookings">
                <h2>Réservations Récentes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Véhicule</th>
                            <th>Client</th>
                            <th>Date de Début</th>
                            <th>Date de Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($reservations) > 0): ?>
                            <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reservation['marque'] . ' ' . $reservation['modele']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['nom'] . ' ' . $reservation['prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['start_date']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['end_date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">Aucune réservation récente.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
            <section class="customer-messages">
                <h2>Messages des Clients</h2>
                <div class="message">
                    <p><strong>John Doe:</strong> Great service, thank you!</p>
                </div>
                <!-- Ajouter d'autres messages ici -->
            </section>

            <!-- Modal pour le calendrier -->
            <div id="calendarModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="calendar"></div>
                    <div class="legend">
                        <span class="reserved">Réservé</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

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
                    <li>Adresse: 1100 R. Notre Dame O, Montréal, QC H3C 1K3</li>
                    <li>Téléphone: +1(514)-000-0000</li>
                    <li>Email: contact@mayar.com</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Suivez-nous</h3>
                <ul class="social-media">
                    <li><a href="#"><img src="image/facebook-icon.png" alt="Facebook"></a></li>
                    <li><a href="#"><img src="image/twitter-icon.png" alt="Twitter"></a></li>
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
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="MonVehicule.js"></script>
</body>
</html>
