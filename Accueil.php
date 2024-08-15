<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mayar - Location de voitures</title>
    <link rel="stylesheet" href="Accueil.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="image/LOGO-3_2.png" alt="Mayar Logo" class="logo-image">
            </div>
            <button class="menu-button" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>
        </div>
    </header>
    <nav class="menu">
        <a href="Accueil.php">Accueil</a>
        <a href="PageConnexion.php">Connexion</a>
        <a href="PageConnexion.php">Inscription</a>
        <a href="Location.php">Devenir Hôte</a>
        <div class="separator"></div>
        
    </nav>
    <main>
        <div class="search-section">
            <div class="search-container">
                <div class="search-item">
                    <label for="location">Lieu</label>
                    <input id="location" type="text" placeholder="Ville, aéroport, adresse ou hôtel">
                </div>
                <div class="search-item">
                    <label for="start-date">Départ</label>
                    <input id="start-date" type="date" value="2024-08-20">
                    <input id="start-time" type="time" value="10:00">
                </div>
                <div class="search-item">
                    <label for="end-date">Retour</label>
                    <input id="end-date" type="date" value="2024-08-27">
                    <input id="end-time" type="time" value="10:00">
                </div>
                <button class="search-button" onclick="searchCars()">Rechercher des voitures</button>
            </div>
        </div>
        <div class="headline">
            <h1>Votre trajet, Notre connexion !</h1>
            <p>Location de voitures auprès d’hôtes de confiance</p>
        </div>
        <div class="explore-section">
            <h2>Explorez les collections</h2>
            <div class="collections">
                <div class="collection-item">
                    <img src="image/2024Tesla.avif" alt="Elctric Car">
                    <h3>Les véhicules électriques les plus récents</h3>
                </div>
                <div class="collection-item">
                    <img src="image/SF90.jpg" alt="Sport Car">
                    <h3>Les véhicules de sport les plus performants</h3>
                </div>
                <div class="collection-item">
                    <img src="image/hyundai-elantra-2022.jpg" alt="Budget Friendly">
                    <h3>Les véhicules les plus économiques</h3>
                </div>
            </div>
        </div>
        <div class="browse-by-make-section">
            <h2>Un large choix de voitures pour tous les goûts</h2>
            <div class="makes">
                <div class="make-item">
                    <img src="image/Logo-honda.png" alt="Honda Logo">
                    <p>Honda</p>
                </div>
                <div class="make-item">
                    <img src="image/logo-tesla.png" alt="Tesla Logo">
                    <p>Tesla</p>
                </div>
                <div class="make-item">
                    <img src="image/logo-toyota.png" alt="Toyota Logo">
                    <p>Toyota</p>
                </div>
                <div class="make-item">
                    <img src="image/logo-porshce.png" alt="Porsche Logo">
                    <p>Porsche</p>
                </div>
                <div class="make-item">
                    <img src="image/logo-bmw.png" alt="BMW Logo">
                    <p>BMW</p>
                </div>
            </div>
        </div>
        <div class="browse-by-destination-section">
            <h2>Votre prochaine destination est plus proche que ce que vous pensez</h2>
            <div class="destinations">
                <div class="destination-item">
                    <img src="image/ville/Toronto.jpg" alt="Toronto">
                    <p>Toronto</p>
                </div>
                <div class="destination-item">
                    <img src="image/ville/Paris.jpg" alt="Paris">
                    <p>Paris</p>
                </div>
                <div class="destination-item">
                    <img src="image/ville/Montreal.jpeg" alt="Montréal">
                    <p>Montréal</p>
                </div>
                <div class="destination-item">
                    <img src="image/ville/miami.jpg" alt="Miami">
                    <p>Miami</p>
                </div>
                <div class="destination-item">
                    <img src="image/ville/Rome.jpg" alt="Rome">
                    <p>Rome</p>
                </div>
                <div class="destination-item">
                    <img src="image/ville/Londre.webp" alt="Londres">
                    <p>Londre</p>
                </div>
            </div>
        </div>
        <div class="blog-section">
            <h2>Réalisez vos rêves</h2>
            <p>Histoires de voyage, actualités et inspirations pour attiser votre désir de voyage.</p>
            <button class="blog-button">Explorez le blog de Mayar</button>
        </div>
        <div class="call-to-action-section">
            <div class="action-item">
                <h3>Louer une voiture</h3>
                <p>À deux pas de chez vous ou à travers le pays, trouvez le véhicule parfait pour votre prochaine aventure.</p>
            </div>
            <div class="action-item">
                <h3>Devenez hôte</h3>
                <p>Accélérez votre esprit d'entreprise et commencez à construire une petite entreprise de partage de voitures avec Mayar.</p>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="Accueil.php">Accueil</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="PageConnexion.php">Connexion</a></li>
                    <li><a href="Location.php">Devenir Hôte</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li>Adresse: 1100 R. Notre Dame O, Montréal, QC H3C 1K3</li>
                    <li>Téléphone: +1 (514)-000-0000</li>
                    <li>Email: contact@mayar.com</li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Suivez-nous</h3>
                <ul class="social-media">
                    <li><a href="#"><img src="image/facebook-icon.png" alt="Facebook"> Mayar</a></li>
                    <li><a href="#"><img src="image/twitter-icon.png" alt="Twitter"> Mayar</a></li>
                    <li><a href="#"><img src="image/Instagram-icon.png.webp" alt="Instagram"> Mayar</a></li>
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
    <script src="Accueil.js"></script>
</body>
</html>
