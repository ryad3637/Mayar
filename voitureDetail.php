<?php
require_once 'config.php';

$pdo = getConnection();
$carId = isset($_GET['id']) ? $_GET['id'] : null;

if ($carId) {
    $stmt = $pdo->prepare("SELECT * FROM Vehicules WHERE vehicule_id = :carId");
    $stmt->execute(['carId' => $carId]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        echo "Voiture non trouvée.";
        exit;
    }
} else {
    echo "ID de voiture manquant.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la voiture</title>
    <link rel="stylesheet" href="VoitureDetail.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="image/LOGO-5.png" alt="Logo de MAYAR">
            </div>
            <nav>
                <a href="#">Accueil</a>
                <a href="#">Support</a>
                <a href="#">Connexion</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="car-details-container">
            <div class="car-details">
                <div class="carousel">
                    <div class="carousel-inner" id="car-images">
                        <!-- Images will be injected here by JavaScript -->
                    </div>
                    <button class="carousel-control prev" onclick="prevSlide()">&#10094;</button>
                    <button class="carousel-control next" onclick="nextSlide()">&#10095;</button>
                </div>
                <h2 id="car-title"><?php echo $car['marque'] . ' ' . $car['modele']; ?></h2>
                <p id="car-trips"><?php echo $car['kilometrage']; ?> km</p>
                <p id="car-pickup"><?php echo $car['adresse']; ?> aéroport</p>
                <p id="car-savings"><?php echo $car['etat']; ?></p>
                <p id="car-originalPrice"><?php echo $car['vin']; ?></p>
                <p id="car-totalPrice"><?php echo $car['prix_quotidien']; ?> $/jour</p>
                <h3>Description</h3>
                <p id="car-description"><?php echo $car['description']; ?></p>
                <h3>Caractéristiques</h3>
                <ul id="car-features">
                    <?php foreach (explode(',', $car['caracteristiques']) as $feature) {
                        echo "<li>" . htmlspecialchars($feature) . "</li>";
                    } ?>
                </ul>
            </div>
            <div class="booking-section">
                <form id="booking-form" action="Paiement.php" method="GET">
                    <h3>Réserver ce véhicule</h3>
                    <label for="start-date">Début du voyage:</label>
                    <input type="date" id="start-date" name="start_date" required>
                    <label for="end-date">Fin du voyage:</label>
                    <input type="date" id="end-date" name="end_date" required>
                    <label for="pickup-location">Lieu de prise en charge et de retour:</label>
                    <input type="text" id="pickup-location" name="pickup_location" value="<?php echo $car['adresse']; ?> aéroport" required>
                    <!-- Hidden input fields to pass car details -->
                    <input type="hidden" name="car_id" value="<?php echo $car['vehicule_id']; ?>">
                    <input type="hidden" name="car_name" value="<?php echo $car['marque'] . ' ' . $car['modele']; ?>">
                    <input type="hidden" name="daily_price" value="<?php echo $car['prix_quotidien']; ?>">
                    <button type="submit" id="payment-button">Procéder au paiement</button>
                </form>
            </div>
        </div>
    </main>
    <script>
        const carData = <?php echo json_encode($car); ?>;
    </script>
    <script src="VoitureDetail.js"></script>
</body>
</html>
