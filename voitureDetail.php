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
                <h2 id="car-title"></h2>
                <p id="car-trips"></p>
                <p id="car-pickup"></p>
                <p id="car-savings"></p>
                <p id="car-originalPrice"></p>
                <p id="car-totalPrice"></p>
                <h3>Description</h3>
                <p id="car-description"></p>
                <h3>Caractéristiques</h3>
                <ul id="car-features"></ul>
            </div>
            <div class="booking-section">
                <h3>Réserver ce véhicule</h3>
                <label for="start-date">Début du voyage:</label>
                <input type="date" id="start-date">
                <label for="end-date">Fin du voyage:</label>
                <input type="date" id="end-date">
                <label for="pickup-location">Lieu de prise en charge et de retour:</label>
                <input type="text" id="pickup-location" placeholder="Lieu de prise en charge et de retour">
                <button id="payment-button">Procéder au paiement</button>
            </div>
        </div>
    </main>
    <script>
        const carData = <?php echo json_encode($car); ?>;
    </script>
    <script src="VoitureDetail.js"></script>
</body>
</html>
