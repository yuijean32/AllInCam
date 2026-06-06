<?php
// config/database.php

$host = 'localhost';
$db   = 'allincam_db'; // Remplacez par le nom exact de votre base de données
$user = 'root';        // Votre identifiant MySQL (ex: root)
$pass = '';            // Votre mot de passe MySQL
$charset = 'utf8mb4';  // Encodage recommandé pour gérer tous les caractères (accents, emojis)

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active la levée d'exceptions en cas d'erreur SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Récupère les résultats sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation pour utiliser les vraies requêtes préparées
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Aspect Cybersécurité : On ne affiche JAMAIS $e->getMessage() à l'écran en production,
    // car cela révélerait la structure des dossiers ou les identifiants du serveur.
    error_log($e->getMessage()); // Enregistre l'erreur dans les logs du serveur
    die("Une erreur technique est survenue. Veuillez réessayer plus tard.");
}