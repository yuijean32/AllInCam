<?php
// index.php - Routeur principal de l'application AllInCam

// 1. Initialisation de la session pour lire les variables globales
session_start();

// 2. Vérification de l'état de connexion
// Si l'utilisateur n'est pas connecté ou que son rôle n'est pas défini, on le force à s'identifier.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: auth/login.php');
    exit; // On arrête toujours l'exécution du script après une redirection
}

// 3. Récupération du rôle de l'utilisateur connecté
$role = $_SESSION['role'];

// 4. Aiguillage (Routage) vers les bonnes vues selon le rôle
switch ($role) {
    case 'admin':
        // L'administrateur est redirigé vers ses statistiques et la modération
        header('Location: views/admin/dashboard.php');
        break;

    case 'partner':
        // Le partenaire (hôtel, loueur de véhicules) est redirigé vers la gestion de son établissement
        header('Location: views/partner/dashboard.php');
        break;

    case 'client':
        // Le client est redirigé vers le moteur de recherche et les réservations
        header('Location: views/client/accueil.php');
        break;

    default:
        // Sécurité supplémentaire : si un rôle inconnu est détecté dans la base de données,
        // on détruit la session corrompue et on renvoie à la connexion.
        session_unset();
        session_destroy();
        header('Location: auth/login.php');
        break;
}

// Fin du script d'aiguillage
exit;