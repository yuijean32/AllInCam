<?php
// views/partner/gerer_ressources.php

$message = "";

if (isset($_POST['btn_ajouter'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=allincam_db;charset=utf8', 'root', '');
        
        $establishment_id = 1; // Simulé
        $resource_name = htmlspecialchars($_POST['resource_name']);
        $base_price = floatval($_POST['base_price']);

        // Création du XML
        $xml = new SimpleXMLElement('<attributes/>');
        $xml->addChild('transmission', htmlspecialchars($_POST['transmission']));
        $xml->addChild('fuel', htmlspecialchars($_POST['fuel']));
        $xml->addChild('kilometrage', htmlspecialchars($_POST['kilometrage']));
        $xml_string = $xml->asXML();

        // Insertion BDD
        $sql = "INSERT INTO resources (establishment_id, name, base_price, specific_attributes) 
                VALUES (:establishment_id, :name, :base_price, :specific_attributes)";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
            ':establishment_id' => $establishment_id,
            ':name' => $resource_name,
            ':base_price' => $base_price,
            ':specific_attributes' => $xml_string
        ]);

        if ($success) $message = "<p style='color: green;'>Véhicule ajouté et XML généré !</p>";
    } catch (Exception $e) {
        $message = "<p style='color: red;'>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer mes ressources - AllInCam</title>
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un véhicule au catalogue</h2>
        <?php echo $message; ?>
        
        <form action="gerer_ressources.php" method="POST">
            <label>Nom du véhicule :</label>
            <input type="text" name="resource_name" required>

            <label>Prix par jour (FCFA) :</label>
            <input type="number" name="base_price" required>

            <fieldset>
                <legend>Attributs spécifiques (XML)</legend>
                <label>Boîte de vitesse :</label>
                <select name="transmission">
                    <option value="Automatique">Automatique</option>
                    <option value="Manuelle">Manuelle</option>
                </select>
                <label>Carburant :</label>
                <select name="fuel">
                    <option value="Essence">Essence</option>
                    <option value="Diesel">Diesel</option>
                </select>
                <label>Kilométrage :</label>
                <input type="text" name="kilometrage" placeholder="Ex: Illimité">
            </fieldset>

            <button type="submit" name="btn_ajouter">Enregistrer le véhicule</button>
        </form>
    </div>
</body>
</html>