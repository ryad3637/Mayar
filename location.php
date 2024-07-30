<?php
require_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: PageConnexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localisation</title>
    <link rel="stylesheet" href="Location.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="image/LOGO-5.png" alt="Logo de MAYAR">
            </div>
            <nav>
                <a href="index.php">Accueil</a>
                <a href="#">Support</a>
                <a href="PageConnexion.php">Connexion</a>
                <a href="Location.php" id="devenir-hote">Devenir Hôte</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h1>Localisation</h1>
            <p>MAYAR a besoin de connaître la localisation de votre véhicule pour s'assurer que nous opérons là où vous êtes.</p>
            <form id="locationForm" action="EnregistrerVehicule.php" method="POST">
                <div class="form-group">
                    <label for="address">Où se trouve votre voiture?</label>
                    <input type="text" id="address" name="address" placeholder="Entrez l'adresse" required>
                </div>
                <button type="submit">Suivant</button>
            </form>
        </div>
    </main>
    <script src="Location.js"></script>
</body>
</html>
