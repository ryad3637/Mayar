<?php
require_once 'config.php';

$pdo = getConnection();
$carId = isset($_GET['vehicule_id']) ? $_GET['vehicule_id'] : null;

if (!$carId) {
    die('ID de voiture manquant.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicule_id = $_POST['vehicule_id'];
    $plaque_immatriculation = $_POST['plaque_immatriculation'];
    $caracteristiques = $_POST['caracteristiques'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("
        UPDATE Vehicules
        SET plaque_immatriculation = :plaque_immatriculation,
            caracteristiques = :caracteristiques,
            description = :description
        WHERE vehicule_id = :vehicule_id
    ");
    $stmt->execute([
        'vehicule_id' => $vehicule_id,
        'plaque_immatriculation' => $plaque_immatriculation,
        'caracteristiques' => $caracteristiques,
        'description' => $description,
    ]);

    header("Location: ModifierVehicule.php?vehicule_id=$vehicule_id");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM Vehicules WHERE vehicule_id = :carId");
$stmt->execute(['carId' => $carId]);
$vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vehicule) {
    die('Voiture non trouvée.');
}

$stmt = $pdo->prepare("SELECT * FROM reservations WHERE vehicule_id = :carId");
$stmt->execute(['carId' => $carId]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Votre Véhicule</title>
    <link rel="stylesheet" href="ModifierVehicule.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales/fr.js'></script>
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
        <a href="index.php">Accueil</a>
        <a href="#">Connexion</a>
        <a href="#">Inscription</a>
        <a href="#">Devenir Hôte</a>
        <div class="separator"></div>
        <a href="#">Support</a>
    </nav>
    <main>
        <div class="main-container">
            <div class="left-section">
                <div class="vehicle-details">
                    <img src="<?php echo htmlspecialchars(json_decode($vehicule['photos'])[0]); ?>" alt="<?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']); ?>">
                    <h2><?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']); ?></h2>
                    <p><?php echo htmlspecialchars($vehicule['finition']); ?></p>
                    <button data-section="details">Détails de la voiture</button>
                    <button data-section="availabilityForm">Disponibilité</button>
                    <button data-section="photos">Photos</button>
                    <button data-section="pricing">Prix quotidien</button>
                    <button data-section="safety">Normes de sécurité</button>
                    <button data-section="viewOnly">Ma voiture</button>
                </div>
            </div>
            <div class="right-section">
                <!-- Section Détails -->
                <div class="section" id="details" style="display: none;">
                    <h2>Détails de la voiture</h2>
                    <form id="detailsForm">
                        <div class="form-group">
                            <label for="licensePlate">Numéro de plaque d'immatriculation</label>
                            <input type="text" id="licensePlate" name="licensePlate" placeholder="Numéro de plaque d'immatriculation" value="<?php echo htmlspecialchars($vehicule['plaque_immatriculation']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Caractéristiques de la voiture</label>
                            <div class="car-features">
                            <textarea id="caracteristiques" name="caracteristiques" required><?php echo htmlspecialchars($vehicule['caracteristiques']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Décrivez ce qui rend votre voiture unique et pourquoi les invités aimeront la conduire." required><?php echo htmlspecialchars($vehicule['description']); ?></textarea>
                            <div class="word-count-container">
                                <small id="wordCount">0 mots</small>
                                <small>Minimum 50 mots</small>
                            </div>
                        </div>
                        <button type="submit">Enregistrer</button>
                    </form>
                </div>
                <!-- Section Disponibilité -->
                <div class="section" id="availabilityForm" style="display: none;">
                    <h2>Disponibilité de la voiture</h2>
                    <form>
                        <div class="form-group">
                            <label for="advanceNotice">Combien de préavis avez-vous besoin avant le début d'un voyage?</label>
                            <select id="advanceNotice" name="advanceNotice" >
                                <option value=""><?php echo htmlspecialchars($vehicule['preavis']); ?></option>
                                <option value="12_hours">12 heures</option>
                                <option value="24_hours">24 heures</option>
                             <option value="48_hours">48 heures</option>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="minTripDuration">Quelle est la durée de voyage minimale que vous accepterez?</label>
                            <select id="minTripDuration" name="minTripDuration" >
                                <option value=""><?php echo htmlspecialchars($vehicule['duree_minimum']); ?></option>
                                <option value="1_day">1 jour</option>
                               <option value="2_days">2 jours</option>
                              <option value="3_days">3 jours</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="maxTripDuration">Quelle est la durée de voyage maximale que vous accepterez?</label>
                            <select id="maxTripDuration" name="maxTripDuration">
                                <option value=""><?php echo htmlspecialchars($vehicule['duree_maximum']); ?></option>
                                <option value="1_week">1 semaine</option>
                                <option value="1_month">1 mois</option>
                                <option value="6_months">6 mois</option>
                            </select>
                        </div>
                        <div id="calendarContainer">
                            <h3>Date de réservation de disponibilité</h3>
                            <div id="calendar"></div>
                            <div class="toggle-switch">
                                <input type="checkbox" id="availabilityToggle" class="toggle-input" checked>
                                <label for="availabilityToggle" class="toggle-label"></label>
                                <span id="toggleStatus">Activé</span>
                            </div>
                        </div><input type="hidden" name="vehicule_id" value="<?php echo htmlspecialchars($vehicule['vehicule_id']); ?>">
                        <input type="hidden" name="disponibilite" id="disponibiliteField">
                        <button type="submit">Enregistrer</button>
                    </form>
                </div>
                <!-- Section Photos -->
                <div class="section" id="photos" style="display: none;">
                    <h2>Photos de la voiture</h2>
                    <div id="photoPreview" class="photo-preview"></div>
                    <form id="photoForm">
                        <div class="form-group">
                            <label for="carPhotos">Ajoutez des photos de votre voiture (maximum 20 photos)</label>
                            <input type="file" id="carPhotos" name="carPhotos" accept="image/*" multiple>
                           
                        </div>
                        <button type="submit">Enregistrer</button>
                    </form>
                </div>
                <!-- Section Prix -->
                <div class="section" id="pricing" style="display: none;">
                    <h2>Prix quotidien</h2>
                    <form>
                        <div class="form-group">
                            <label for="dailyPrice">Prix quotidien</label>
                            <input type="number" id="dailyPrice" name="dailyPrice" placeholder="$" value="<?php echo htmlspecialchars($vehicule['prix_quotidien']); ?>" required>
                            <small>Le prix moyen de la location quotidienne est : <?php echo htmlspecialchars($vehicule['prix_quotidien']); ?></small>
                        </div>
                        <button type="submit">Enregistrer</button>
                    </form>
                </div>
                <!-- Section Normes de Sécurité -->
                <div class="section" id="safety" style="display: none;">
                    <h2>Normes de sécurité et de qualité</h2>
                    <form>
                        <div class="form-group">
                            <p>Nous nous efforçons de maintenir une communauté de partage de voiture sûre et fiable. En tant qu'hôte, vous devez respecter ces normes :</p>
                            <h3>Maintenance</h3>
                            <ul>
                                <li>Maintenez votre voiture en bon état afin que vos invités restent en sécurité sur la route. Vous devrez passer une inspection annuelle pour chaque voiture que vous mettez en location.</li>
                            </ul>
                            <h3>Nettoyage</h3>
                            <ul>
                                <li>Nettoyez et ravitaillez votre voiture avant chaque voyage afin que vos invités passent un moment agréable.</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="acceptStandards" name="acceptStandards" required> J'accepte les normes de sécurité et de qualité.
                        </div>
                        <button type="submit">Enregistrer</button>
                    </form>
                </div>
                <!-- Section Vue Seulement -->
                <div class="section" id="viewOnly">
                    <h2>Ma voiture</h2>
                    <div class="vehicle-view-only">
                        <div class="gallery-container">
                            <span class="prev" onclick="changeSlide(-1)">&#10094;</span>
                            <img id="mainImage" src="<?php echo htmlspecialchars(json_decode($vehicule['photos'])[0]); ?>" alt="Photo de la voiture" class="main-image">
                            <span class="next" onclick="changeSlide(1)">&#10095;</span>
                        </div>
                        <h2><?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['modele']); ?></h2>
                        <p><strong>Adresse:</strong> <?php echo htmlspecialchars($vehicule['adresse']); ?></p>
                        <p><strong>Marque:</strong> <?php echo htmlspecialchars($vehicule['marque']); ?></p>
                        <p><strong>Modèle:</strong> <?php echo htmlspecialchars($vehicule['modele']); ?></p>
                        <p><strong>Année:</strong> <?php echo htmlspecialchars($vehicule['annee']); ?></p>
                        <p><strong>Numéro VIN:</strong> <?php echo htmlspecialchars($vehicule['vin']); ?></p>
                        <p><strong>Kilométrage:</strong> <?php echo htmlspecialchars($vehicule['kilometrage']); ?></p>
                        <p><strong>Transmission:</strong> <?php echo htmlspecialchars($vehicule['transmission']); ?></p>
                        <p><strong>Finition:</strong> <?php echo htmlspecialchars($vehicule['finition']); ?></p>
                        <p><strong>Style:</strong> <?php echo htmlspecialchars($vehicule['style']); ?></p>
                        <p><strong>Plaque d'immatriculation:</strong> <?php echo htmlspecialchars($vehicule['plaque_immatriculation']); ?></p>
                        <p><strong>Caractéristiques:</strong> <?php echo htmlspecialchars($vehicule['caracteristiques']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($vehicule['description']); ?></p>
                        <p><strong>Préavis:</strong> <?php echo htmlspecialchars($vehicule['preavis']); ?></p>
                        <p><strong>Durée minimale de voyage:</strong> <?php echo htmlspecialchars($vehicule['duree_minimum']); ?></p>
                        <p><strong>Durée maximale de voyage:</strong> <?php echo htmlspecialchars($vehicule['duree_maximum']); ?></p>
                        <p><strong>Prix quotidien:</strong> <?php echo htmlspecialchars($vehicule['prix_quotidien']); ?></p>
                        <p><strong>Normes de sécurité:</strong> <?php echo htmlspecialchars($vehicule['normes_acceptees']); ?></p>
                    </div>
                </div>
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
                    <li><a href="location.php">Devenir Hôte</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li>Adresse: 123 Rue de la Location, Ville, Pays</li>
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
    
    <script>
        const vehiculeData = <?php echo json_encode($vehicule); ?>;
        const reservationsData = <?php echo json_encode($reservations); ?>;
    </script>
    <script src="ModifierVehicule.js"></script>
</body>
</html>
