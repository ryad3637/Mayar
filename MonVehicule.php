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
            <a href="index.html">Accueil</a>
            <a href="#">Connexion</a>
            <a href="#">Inscritpion</a>
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
                    <div class="card">
                        <button class="calendar-button">📅</button>
                        <div class="image-container">
                            <img src="car1.jpg" alt="BMW X5">
                        </div>
                        <h3>BMW X5</h3>
                        <p class="price">$72 <span>/jour</span></p>
                        <p>Type: SUV</p>
                        <p>Statut: Disponible</p>
                        <div class="card-actions">
                            <button>Modifier</button>
                            <button>Supprimer</button>
                        </div>
                    </div>
                    <div class="card">
                        <button class="calendar-button">📅</button>
                        <div class="image-container">
                            <img src="car2.jpg" alt="Audi A4">
                        </div>
                        <h3>Audi A4</h3>
                        <p class="price">$65 <span>/jour</span></p>
                        <p>Type: Sedan</p>
                        <p>Statut: Loué</p>
                        <div class="card-actions">
                            <button>Modifier</button>
                            <button>Supprimer</button>
                        </div>
                    </div>
                </div>
                <div class="no-vehicles-message" id="noVehiclesMessage">
                    <p>Vous n'avez aucun véhicule ajouté. Ajoutez un véhicule maintenant et commencez à gagner de l'argent!</p>
                    <a href="EnregistrerVehicule.html" class="add-vehicle-button">Ajouter Véhicule</a>
                </div>
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
                        <tr>
                            <td>BMW X5</td>
                            <td>John Doe</td>
                            <td>2024-07-20</td>
                            <td>2024-07-22</td>
                        </tr>
                        <!-- Ajouter d'autres réservations ici -->
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
