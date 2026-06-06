<?php
// views/partner/gerer_ressources.php
session_start();

// Vérification de sécurité
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'partner') {
    header('Location: ../../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer mes ressources - AllInCam</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <h2>Ajouter une nouvelle ressource</h2>

    <form partner="../../partner/gerer_resources.php" method="POST">
       
        <input type="hidden" name="establishment_id" value="1">

        <label>Nom de la ressource :</label>
        <input type="text" name="name" placeholder="Ex: Chambre Double" required>

        <label>Prix de base (FCFA) :</label>
        <input type="number" name="base_price" required>

        <label>Type de ressource :</label>
        <select name="resource_type" required>
            <option value="chambre">Chambre d'hôtel</option>
            <option value="vehicule">Véhicule</option>
        </select>

        <hr>
        <h3>Si c'est une chambre :</h3>
        <label>Nombre de lits : <input type="number" name="lits"></label>
        <label>Wifi : <input type="checkbox" name="wifi" value="1"></label>

        <h3>Si c'est un véhicule :</h3>
        <label>Carburant : <input type="text" name="carburant"></label>
        <label>Places : <input type="number" name="places"></label>

        <button type="submit">Enregistrer la ressource</button>
    </form>
</body>
</html