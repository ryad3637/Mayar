<?php


$isLoggedIn = isset($_SESSION['user_id']);
$profilePhoto = 'default_photo_path.jpg';
$prenom = 'Guest';
$nom = '';

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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = htmlspecialchars($_POST['address']);
    header("Location: EnregistrerVehicule.php?address=" . urlencode($address));
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer votre voiture</title>
    <link rel="stylesheet" href="EnregistrerVehicule.css">
</head>
<body>

    <div class="background-image"></div>
    
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
    <nav class="menu" id="menu">
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
        <div class="form-container">
            <h1>Enregistrer votre voiture</h1>
            <div class="progress-container">
                <div class="progress-bar" id="progress-bar"></div>
            </div>
            <div id="error-message" class="error-message"></div>
            <form id="mainForm" method="POST">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>"> 
                <!-- Section 1: Votre voiture -->
                <div class="form-section" id="section1">
                    <h2>Votre voiture</h2>
                    <div class="form-group">
                        <label for="address">Où se trouve votre voiture?</label>
                        <input type="text" id="address" name="address" value="<?php echo isset($_GET['address']) ? htmlspecialchars($_GET['address']) : ''; ?>" readonly>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="marque">Marque de la voiture</label>
                            <select id="marque" name="marque" required>
                                <option value="">--Sélectionnez--</option>
                                <option value="Acura">Acura</option>
                                <option value="Alfa Romeo">Alfa Romeo</option>
                                <option value="Aston Martin">Aston Martin</option>
                                <option value="Audi">Audi</option>
                                <option value="Bentley">Bentley</option>
                                <option value="BMW">BMW</option>
                                <option value="Bugatti">Bugatti</option>
                                <option value="Buick">Buick</option>
                                <option value="Cadillac">Cadillac</option>
                                <option value="Chevrolet">Chevrolet</option>
                                <option value="Chrysler">Chrysler</option>
                                <option value="Citroen">Citroën</option>
                                <option value="Dodge">Dodge</option>
                                <option value="Ferrari">Ferrari</option>
                                <option value="Fiat">Fiat</option>
                                <option value="Ford">Ford</option>
                                <option value="Genesis">Genesis</option>
                                <option value="GMC">GMC</option>
                                <option value="Honda">Honda</option>
                                <option value="Hummer">Hummer</option>
                                <option value="Hyundai">Hyundai</option>
                                <option value="Infiniti">Infiniti</option>
                                <option value="Jaguar">Jaguar</option>
                                <option value="Jeep">Jeep</option>
                                <option value="Kia">Kia</option>
                                <option value="Lamborghini">Lamborghini</option>
                                <option value="Land Rover">Land Rover</option>
                                <option value="Lexus">Lexus</option>
                                <option value="Lincoln">Lincoln</option>
                                <option value="Lotus">Lotus</option>
                                <option value="Maserati">Maserati</option>
                                <option value="Mazda">Mazda</option>
                                <option value="McLaren">McLaren</option>
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="Mini">Mini</option>
                                <option value="Mitsubishi">Mitsubishi</option>
                                <option value="Nissan">Nissan</option>
                                <option value="Pagani">Pagani</option>
                                <option value="Peugeot">Peugeot</option>
                                <option value="Polestar">Polestar</option>
                                <option value="Porsche">Porsche</option>
                                <option value="Ram">Ram</option>
                                <option value="Renault">Renault</option>
                                <option value="Rolls-Royce">Rolls-Royce</option>
                                <option value="Saab">Saab</option>
                                <option value="Subaru">Subaru</option>
                                <option value="Suzuki">Suzuki</option>
                                <option value="Tesla">Tesla</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Volkswagen">Volkswagen</option>
                                <option value="Volvo">Volvo</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="model">Modèle de la voiture</label>
                            <input type="text" id="model" name="model" placeholder="Ex: Passat" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Année de la voiture</label>
                            <select id="year" name="year" required>
                                <option value="">Sélectionnez</option>
                                <!-- Options de 1900 à 2025 générées par JavaScript -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vin">Numéro VIN</label>
                        <input type="text" id="vin" name="vin" placeholder="Numéro VIN" required>
                    </div>
                    <div class="form-group">
                        <label for="mileage">Kilométrage</label>
                        <input type="text" id="mileage" name="mileage" placeholder="Ex: 50000 km" required>
                    </div>
                    <div class="form-group">
                        <label for="transmission">Transmission</label>
                        <div>
                            <input type="radio" id="transmission-automatic" name="transmission" value="Automatique" checked> Automatique
                            <input type="radio" id="transmission-manual" name="transmission" value="Manuelle"> Manuelle
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="finition">Finition (optionnel)</label>
                        <input type="text" id="finition" name="finition" placeholder="Ex: Édition Limitée">
                    </div>
                    <div class="form-group">
                        <label for="style">Style (optionnel)</label>
                        <input type="text" id="style" name="style" placeholder="Ex: Berline 4 portes">
                    </div>
                    <div class="form-group">
                        <label>J'atteste avoir payé les taxes applicables lors de l'achat de ce véhicule</label>
                        <div>
                            <input type="radio" id="taxes-yes" name="taxes" value="Oui" checked> Oui
                            <input type="radio" id="taxes-no" name="taxes" value="Non"> Non
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="no-salvage" name="no-salvage" checked> Ma voiture n'a jamais eu de titre de marque ou de sauvetage.
                    </div>
                    <button type="button" onclick="nextSection('section2')">Next</button>
                </div>
                <!-- Section 2: Détails de la voiture -->
                <div class="form-section" id="section2" style="display: none;">
                    <h2>Détails de la voiture</h2>
                    <div class="form-group">
                        <label for="licensePlate">Numéro de plaque d'immatriculation</label>
                        <input type="text" id="licensePlate" name="licensePlate" placeholder="Numéro de plaque d'immatriculation" required>
                    </div>
                    <div class="form-group">
                        <label for="state">État</label>
                        <select id="state" name="state" required>
                            <option value="">Sélectionnez</option>
                            <option value="PA">Pennsylvania</option>
                            <!-- Ajoutez d'autres options ici -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Caractéristiques de la voiture</label>
                        <div class="car-features">
                            <label><input type="checkbox" name="features[]" value="All-wheel drive"> Traction intégrale</label>
                            <label><input type="checkbox" name="features[]" value="Android Auto"> Android Auto</label>
                            <label><input type="checkbox" name="features[]" value="Apple CarPlay"> Apple CarPlay</label>
                            <label><input type="checkbox" name="features[]" value="AUX input"> Entrée AUX</label>
                            <label><input type="checkbox" name="features[]" value="Backup camera"> Caméra de recul</label>
                            <label><input type="checkbox" name="features[]" value="Bike rack"> Porte-vélos</label>
                            <label><input type="checkbox" name="features[]" value="Blind spot warning"> Avertissement angle mort</label>
                            <label><input type="checkbox" name="features[]" value="Bluetooth"> Bluetooth</label>
                            <label><input type="checkbox" name="features[]" value="Child seat"> Siège enfant</label>
                            <label><input type="checkbox" name="features[]" value="Convertible"> Cabriolet</label>
                            <label><input type="checkbox" name="features[]" value="GPS"> GPS</label>
                            <label><input type="checkbox" name="features[]" value="Heated seats"> Sièges chauffants</label>
                            <label><input type="checkbox" name="features[]" value="Keyless entry"> Entrée sans clé</label>
                            <label><input type="checkbox" name="features[]" value="Pet friendly"> Animaux acceptés</label>
                            <label><input type="checkbox" name="features[]" value="Ski rack"> Porte-skis</label>
                            <label><input type="checkbox" name="features[]" value="Snow tires or chains"> Pneus neige ou chaînes</label>
                            <label><input type="checkbox" name="features[]" value="Sunroof"> Toit ouvrant</label>
                            <label><input type="checkbox" name="features[]" value="Toll pass"> Télépéage</label>
                            <label><input type="checkbox" name="features[]" value="USB charger"> Chargeur USB</label>
                            <label><input type="checkbox" name="features[]" value="USB input"> Entrée USB</label>
                            <label><input type="checkbox" name="features[]" value="Wheelchair accessible"> Accessible aux fauteuils roulants</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Décrivez ce qui rend votre voiture unique et pourquoi les invités aimeront la conduire." required></textarea>
                        <div class="word-count-container">
                            <small id="wordCount">0 mots</small>
                            <small>Minimum 50 mots</small>
                        </div>
                    </div>
                    <button type="button" onclick="previousSection('section1')">Previous</button>
                    <button type="button" onclick="nextSection('section3')">Next</button>
                </div>
                <!-- Section 3: Disponibilité de la voiture -->
                <div class="form-section" id="section3" style="display: none;">
                    <h2>Disponibilité de la voiture</h2>
                    <div class="form-group">
                        <label for="advanceNotice">Combien de préavis avez-vous besoin avant le début d'un voyage?</label>
                        <select id="advanceNotice" name="advanceNotice" required>
                            <option value="">Sélectionnez</option>
                            <option value="12_hours">12 heures (recommandé)</option>
                            <option value="24_hours">24 heures</option>
                            <option value="48_hours">48 heures</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="minTripDuration">Quelle est la durée de voyage minimale que vous accepterez?</label>
                        <select id="minTripDuration" name="minTripDuration" required>
                            <option value="">Sélectionnez</option>
                            <option value="1_day">1 jour (recommandé)</option>
                            <option value="2_days">2 jours</option>
                            <option value="3_days">3 jours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="maxTripDuration">Quelle est la durée de voyage maximale que vous accepterez?</label>
                        <select id="maxTripDuration" name="maxTripDuration" required>
                            <option value="">Sélectionnez</option>
                            <option value="1_month">1 mois (recommandé)</option>
                            <option value="2_months">2 mois</option>
                            <option value="3_months">3 mois</option>
                        </select>
                    </div>
                    <button type="button" onclick="previousSection('section2')">Previous</button>
                    <button type="button" onclick="nextSection('section4')">Next</button>
                </div>
                <!-- Section 4: Photos de la voiture -->
                <div class="form-section" id="section4" style="display: none;">
                    <h2>Photos de la voiture</h2>
                    <div class="form-group">
                        <label for="photos">Ajoutez des photos de votre voiture (maximum 20 photos)</label>
                        <input type="file" id="photos" name="photos" accept="image/*" multiple>
                        <div id="photoPreview" class="photo-preview"></div>
                    </div>
                    <button type="button" onclick="previousSection('section3')">Previous</button>
                    <button type="button" onclick="nextSection('section5')">Next</button>
                </div>
                <!-- Section 5: Prix quotidien -->
                <div class="form-section" id="section5" style="display: none;">
                    <h2>Prix quotidien</h2>
                    <div class="form-group">
                        <label for="dailyPrice">Prix quotidien</label>
                        <input type="number" id="dailyPrice" name="dailyPrice" placeholder="$" required>
                        <small>Prix recommandé : $44</small>
                    </div>
                    <button type="button" onclick="previousSection('section4')">Previous</button>
                    <button type="button" onclick="nextSection('section6')">Next</button>
                </div>
                <!-- Section 6: Normes de sécurité et de qualité -->
                <div class="form-section" id="section6" style="display: none;">
                    <h2>Normes de sécurité et de qualité</h2>
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
                    <button type="button" onclick="previousSection('section5')">Previous</button>
                    <button type="button" onclick="nextSection('section7')">Next</button>
                </div>
                <!-- Section 7: Soumettre votre annonce -->
                <div class="form-section" id="section7" style="display: none;">
                    <h2>Soumettre votre annonce</h2>
                    <div class="form-group">
                        <p>Vous y êtes presque ! En appuyant sur "Soumettre annonce", vous acceptez les termes de service de notre plateforme.</p>
                        <a href="#">Voir les termes de service</a>
                        <div class="form-group">
                            <input type="checkbox" id="agreeTerms" name="agreeTerms" required> En cochant cette case, j'accepte les termes de service.
                        </div>
                    </div>
                    <button type="button" onclick="previousSection('section6')">Previous</button>
                    <button id="btn-form" type="submit">Soumettre annonce</button>
                </div>
            </form>
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
    
    <script src="EnregistrerVehicule.js"></script>
</body>
</html>
