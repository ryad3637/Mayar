<?php

require_once __DIR__.'/router.php';
require_once 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);
$profilePhoto = $isLoggedIn ? ($_SESSION['photo_profil'] ?? 'default_photo_path.jpg') : '';


// Helper function to send JSON response
if (!function_exists('sendJsonResponse')) {
    function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}

// Route pour déconnexion
get('/deconnexion', function() {
  
    session_unset();
    session_destroy();
    header('Location: PageConnexion.php');
    exit();
});

post('/api/signup', function() {
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        sendJsonResponse(['message' => 'Invalid JSON format']);
        return;
    }

    $pdo = getConnection();
    $nom = $input['name'];
    $prenom = $input['prenom'];
    $email = $input['email'];
    $password = password_hash($input['password'], PASSWORD_BCRYPT);
    $phone = $input['phone'];
    $birthdate = $input['birthdate'];
    $license = $input['license'];

    $stmt = $pdo->prepare("INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe_hash, numero_telephone, date_naissance, numero_permis_conduire, role) VALUES (:nom, :prenom, :email, :mot_de_passe_hash, :numero_telephone, :date_naissance, :numero_permis_conduire, 'client')");
    
    if ($stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'mot_de_passe_hash' => $password,
        'numero_telephone' => $phone,
        'date_naissance' => $birthdate,
        'numero_permis_conduire' => $license
    ])) {
        sendJsonResponse(['message' => 'Inscription réussie']);
    } else {
        sendJsonResponse(['message' => 'Erreur lors de l\'inscription']);
    }
});

function sendJsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
post('/api/login', function() {
    $input = json_decode(file_get_contents('php://input'), true);
    $pdo = getConnection();

    $email = $input['email'];
    $password = $input['password'];

    $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        sendJsonResponse(['message' => 'Connexion réussie', 'user' => $user]);
    } else {
        sendJsonResponse(['message' => 'Email ou mot de passe incorrect']);
    }
});

post('/api/registerVehicle', function() {
    $input = json_decode(file_get_contents('php://input'), true);
    $pdo = getConnection();

    // Log the received data for debugging
    error_log('Received data: ' . print_r($input, true));

    // Validate that all expected fields are present
    $requiredFields = ['user_id', 'address', 'marque','model', 'year', 'vin', 'mileage', 'transmission', 'licensePlate', 'state', 'description', 'advanceNotice', 'minTripDuration', 'maxTripDuration', 'dailyPrice', 'acceptStandards', 'photos'];

    foreach ($requiredFields as $field) {
        if (!isset($input[$field])) {
            echo json_encode(['message' => "Field '$field' is required"]);
            return;
        }
    }

    $userId = $input['user_id'];

    $stmt = $pdo->prepare("SELECT role FROM Utilisateurs WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['message' => 'User not found']);
        return;
    }

    if ($user['role'] !== 'proprietaire') {
        $stmt = $pdo->prepare("UPDATE Utilisateurs SET role = 'proprietaire' WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    $adresse = $input['address'];
    $marque = $input['marque'];
    $modele = $input['model'];
    $annee = $input['year'];
    $vin = $input['vin'];
    $kilometrage = $input['mileage'];
    $transmission = $input['transmission'];
    $finition = $input['finition'];
    $style = $input['style'];
    $taxes = $input['taxes'] === 'Oui' ? 1 : 0;
    $noSalvage = $input['no_salvage'] ? 1 : 0;
    $plaqueImmatriculation = $input['licensePlate'];
    $etat = $input['state'];
    $caracteristiques = isset($input['features']) ? implode(',', $input['features']) : '';
    $description = $input['description'];
    $preavis = $input['advanceNotice'];
    $dureeMinimum = $input['minTripDuration'];
    $dureeMaximum = $input['maxTripDuration'];
    $prixQuotidien = $input['dailyPrice'];
    $normesAcceptees = $input['acceptStandards'] ? 1 : 0;
    $photos = json_encode($input['photos']); // JSON string of photos

    $stmt = $pdo->prepare("INSERT INTO Vehicules (
        user_id, adresse, marque, modele, annee, vin, kilometrage, transmission, finition, style, taxes_payees, no_salvage, 
        plaque_immatriculation, etat, caracteristiques, description, preavis, duree_minimum, duree_maximum, 
        prix_quotidien, normes_acceptees, photos
    ) VALUES (
        :user_id, :adresse, :marque, :modele, :annee, :vin, :kilometrage, :transmission, :finition, :style, :taxes_payees, :no_salvage, 
        :plaque_immatriculation, :etat, :caracteristiques, :description, :preavis, :duree_minimum, :duree_maximum, 
        :prix_quotidien, :normes_acceptees, :photos
    )");

    try {
        if ($stmt->execute([
            'user_id' => $userId,
            'adresse' => $adresse,
            'marque' => $marque,
            'modele' => $modele,
            'annee' => $annee,
            'vin' => $vin,
            'kilometrage' => $kilometrage,
            'transmission' => $transmission,
            'finition' => $finition,
            'style' => $style,
            'taxes_payees' => $taxes,
            'no_salvage' => $noSalvage,
            'plaque_immatriculation' => $plaqueImmatriculation,
            'etat' => $etat,
            'caracteristiques' => $caracteristiques,
            'description' => $description,
            'preavis' => $preavis,
            'duree_minimum' => $dureeMinimum,
            'duree_maximum' => $dureeMaximum,
            'prix_quotidien' => $prixQuotidien,
            'normes_acceptees' => $normesAcceptees,
            'photos' => $photos
        ])) {
            echo json_encode(['message' => 'Véhicule enregistré avec succès']);
        } else {
            error_log('SQL execution error: ' . print_r($stmt->errorInfo(), true));
            echo json_encode(['message' => 'Erreur lors de l\'enregistrement du véhicule']);
        }
    } catch (PDOException $e) {
        error_log('PDOException: ' . $e->getMessage());
        echo json_encode(['message' => 'Erreur lors de l\'enregistrement du véhicule: ' . $e->getMessage()]);
    }
});

post('/api/uploadPhotos', function() {
    // Create an array to hold the paths of uploaded files
    $filePaths = [];

    // Directory where the photos will be stored
    $targetDir = "uploads/";

    // Ensure the directory exists
    if (!file_exists($targetDir) && !mkdir($targetDir, 0777, true)) {
        sendJsonResponse(['message' => 'Erreur lors de la création du répertoire de téléchargement']);
    }

    foreach ($_FILES['photos']['name'] as $key => $name) {
        $targetFile = $targetDir . basename($name);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['photos']['tmp_name'][$key], $targetFile)) {
            $filePaths[] = $targetFile;
        } else {
            sendJsonResponse(['message' => 'Erreur lors du téléchargement des photos']);
        }
    }

    sendJsonResponse(['filePaths' => $filePaths]);
});

get('/api/getVehicles', function() {
    header('Content-Type: application/json');
    $pdo = getConnection();

    $stmt = $pdo->prepare("SELECT * FROM Vehicules");
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($vehicles);
});

post('/api/photoProfil', function() {
    require_once 'uploadProfilePhoto.php';
});

post('/api/createConversation', function() {
    $input = json_decode(file_get_contents('php://input'), true);
    $pdo = getConnection();

    $user1_id = $input['user1_id'];
    $user2_id = $input['user2_id'];
    $vehicle_id = $input['vehicle_id'];

    $stmt = $pdo->prepare("INSERT INTO conversations (user1_id, user2_id, vehicle_id) VALUES (:user1_id, :user2_id, :vehicle_id)");
    if ($stmt->execute(['user1_id' => $user1_id, 'user2_id' => $user2_id, 'vehicle_id' => $vehicle_id])) {
        sendJsonResponse(['message' => 'Conversation created successfully', 'conversation_id' => $pdo->lastInsertId()]);
    } else {
        sendJsonResponse(['message' => 'Error creating conversation']);
    }
});

post('/api/sendMessage', function() {
    $input = json_decode(file_get_contents('php://input'), true);
    $pdo = getConnection();

    $conversation_id = $input['conversation_id'];
    $sender_id = $input['sender_id'];
    $message = $input['message'];

    $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, sender_id, message) VALUES (:conversation_id, :sender_id, :message)");
    if ($stmt->execute(['conversation_id' => $conversation_id, 'sender_id' => $sender_id, 'message' => $message])) {
        sendJsonResponse(['message' => 'Message sent successfully']);
    } else {
        sendJsonResponse(['message' => 'Error sending message']);
    }
});

get('/api/getMessages', function() {
    $conversation_id = $_GET['conversation_id'];
    $pdo = getConnection();

    $stmt = $pdo->prepare("SELECT * FROM messages WHERE conversation_id = :conversation_id ORDER BY timestamp ASC");
    $stmt->execute(['conversation_id' => $conversation_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    sendJsonResponse($messages);
});
// chemin routes

get('/', function() use ($isLoggedIn, $profilePhoto) {
    include 'index.php';
});
get('/index.php', function() use ($isLoggedIn, $profilePhoto) {
    include 'index.php';
});
get('/', 'index.php');
get('/index.php', 'index.php');
get('/PageConnexion.php', 'PageConnexion.php');
get('/Location.php', 'location.php');
get('/EnregistrerVehicule.php', 'EnregistrerVehicule.php');
get('/VoitureDetail.php', 'voitureDetail.php');
get('/Hreservation.php', 'Hreservation.php');
get('/MonCompte.php', 'MonCompte.php');
get('/chat', 'chat.php');
get('/fetchMessages.php', 'fetchMessages.php');

any('/404','views/404.php');





// POST routes
post('/user', '/api/save_user');
any('/404','views/404.php');
post('/api/uploadPhotos', 'uploadPhotos.php');
?>
