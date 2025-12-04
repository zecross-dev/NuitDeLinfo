<?php
header('Content-Type: application/json');

// Configuration
$destinataire = "contact@techsolutions.com"; // Changez avec votre email
$sujet = "Nouveau message depuis le site web";

// Fonction de validation et nettoyage
function nettoyer_donnees($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validation des données POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupération et nettoyage des données
    $nom = isset($_POST['nom']) ? nettoyer_donnees($_POST['nom']) : '';
    $email = isset($_POST['email']) ? nettoyer_donnees($_POST['email']) : '';
    $telephone = isset($_POST['telephone']) ? nettoyer_donnees($_POST['telephone']) : '';
    $message = isset($_POST['message']) ? nettoyer_donnees($_POST['message']) : '';
    
    // Validation
    $erreurs = [];
    
    if (empty($nom)) {
        $erreurs[] = "Le nom est requis";
    }
    
    if (empty($email)) {
        $erreurs[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide";
    }
    
    if (empty($message)) {
        $erreurs[] = "Le message est requis";
    }
    
    // Si des erreurs existent
    if (!empty($erreurs)) {
        echo json_encode([
            'success' => false,
            'message' => implode(', ', $erreurs)
        ]);
        exit;
    }
    
    // Construction du message email
    $corps_message = "Nouveau message reçu depuis le site web\n\n";
    $corps_message .= "Nom: $nom\n";
    $corps_message .= "Email: $email\n";
    $corps_message .= "Téléphone: $telephone\n\n";
    $corps_message .= "Message:\n$message\n";
    
    // Headers de l'email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Envoi de l'email
    if (mail($destinataire, $sujet, $corps_message, $headers)) {
        // Optionnel: Enregistrer dans une base de données
        // enregistrerDansDB($nom, $email, $telephone, $message);
        
        echo json_encode([
            'success' => true,
            'message' => 'Merci pour votre message ! Nous vous répondrons dans les plus brefs délais.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de l\'envoi du message. Veuillez réessayer plus tard.'
        ]);
    }
    
} else {
    // Si la requête n'est pas POST
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
}

// Fonction optionnelle pour enregistrer dans une base de données
function enregistrerDansDB($nom, $email, $telephone, $message) {
    /*
    // Configuration de la connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "votre_utilisateur";
    $mot_de_passe = "votre_mot_de_passe";
    $base_de_donnees = "votre_base";
    
    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $utilisateur, $mot_de_passe);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO contacts (nom, email, telephone, message, date_creation) 
                VALUES (:nom, :email, :telephone, :message, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':message', $message);
        
        $stmt->execute();
        
        return true;
    } catch(PDOException $e) {
        error_log("Erreur DB: " . $e->getMessage());
        return false;
    }
    */
}

/*
-- Structure SQL pour créer la table contacts (optionnel)

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telephone VARCHAR(20),
    message TEXT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('nouveau', 'lu', 'traité') DEFAULT 'nouveau'
);
*/
?>