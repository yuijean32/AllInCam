<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO resources (establishment_id, name, base_price, resource_type) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    // Note : establishment_id sera à lier à l'ID du partenaire
    $stmt->execute([1, $_POST['name'], $_POST['base_price'], $_POST['resource_type']]);
    header('Location: ../views/partner/dashboard.php?success=1');
}