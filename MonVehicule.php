<?php
session_start();

// Si l'utilisateur n'est pas connecté, redirigez vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: /PageConnexion.php');
    exit();
}

// Connexion à la base de données
require_once 'config.php';
$pdo = getConnection();

// Récupérer les informations du véhicule de l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM Vehicules WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Véhicules</title>
    <link rel="stylesheet" href="MonVehicule.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="image/LOGO-5.png" alt="Logo de MAYAR">
            </div>
            <nav>
                <a href="RechercheVoiture.php">Accueil</a>
                <a href="#">Support</a>
                <a href="/PageConnexion.php">Connexion</a>
                <a href="/Location.php" id="devenir-hote">Devenir Hôte</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="main-container">
            <div class="left-section">
                <h2>Mes Véhicules</h2>
                <?php foreach ($vehicules as $vehicule): ?>
                    <div class="vehicle-details">
                        <img src="<?= htmlspecialchars($vehicule['photo']) ?>" alt="Photo du véhicule">
                        <h3><?= htmlspecialchars($vehicule['model']) ?></h3>
                        <p>Localisation : <?= htmlspecialchars($vehicule['address']) ?></p>
                        <p>Kilométrage : <?= htmlspecialchars($vehicule['mileage']) ?></p>
                        <button onclick="location.href='ModifierVehicule.php?id=<?= $vehicule['id'] ?>'">Modifier</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="right-section">
                <h2>Calendrier des Réservations</h2>
                <div id="calendarContainer">
                    <table>
                        <thead>
                            <tr>
                                <th>Dim</th>
                                <th>Lun</th>
                                <th>Mar</th>
                                <th>Mer</th>
                                <th>Jeu</th>
                                <th>Ven</th>
                                <th>Sam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Remplir dynamiquement avec les données de réservation -->
                            <?php
                            // Exemple de génération de dates pour le mois courant
                            $year = date('Y');
                            $month = date('m');
                            $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            $first_day_of_month = date('w', mktime(0, 0, 0, $month, 1, $year));
                            $current_day = 1;

                            for ($week = 0; $week < 6; $week++): ?>
                                <tr>
                                    <?php for ($day = 0; $day < 7; $day++): ?>
                                        <?php if ($week == 0 && $day < $first_day_of_month): ?>
                                            <td class="empty"></td>
                                        <?php elseif ($current_day > $num_days): ?>
                                            <td class="empty"></td>
                                        <?php else: ?>
                                            <td>
                                                <?= $current_day ?>
                                                <div class="price">$<?= rand(50, 150) ?></div>
                                            </td>
                                            <?php $current_day++; ?>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="MonVehicule.js"></script>
</body>
</html>
