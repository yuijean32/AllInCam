<?php
// views/client/ajouter_avis.php
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=allincam_db;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Connexion BDD impossible']);
    exit;
}

$donneesRecues = json_decode(file_get_contents('php://input'), true);

if (!$donneesRecues) {
    echo json_encode(['status' => 'error', 'message' => 'Données invalides']);
    exit;
}

$user_id = 2; // Simulé
$establishment_id = intval($donneesRecues['establishment_id']);
$rating = intval($donneesRecues['rating']);
$comment = htmlspecialchars($donneesRecues['comment']);

// Contrôle de sécurité métier
$sqlCheck = "SELECT COUNT(*) FROM reservations r
            JOIN resources res ON r.resource_id = res.id
            WHERE r.user_id = :user_id AND res.establishment_id = :establishment_id AND r.status = 'confirme'";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':user_id' => $user_id, ':establishment_id' => $establishment_id]);

if ($stmtCheck->fetchColumn() == 0) {
    echo json_encode(['status' => 'error', 'message' => '🔒 Sécurité : Séjour validé requis pour laisser un avis.']);
    exit;
}

// Insertion
$sqlInsert = "INSERT INTO reviews (user_id, establishment_id, rating, comment) VALUES (:user_id, :establishment_id, :rating, :comment)";
$stmtInsert = $pdo->prepare($sqlInsert);
$stmtInsert->execute([':user_id' => $user_id, ':establishment_id' => $establishment_id, ':rating' => $rating, ':comment' => $comment]);

echo json_encode(['status' => 'success', 'message' => 'Avis publié avec succès !']);