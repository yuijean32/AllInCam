<?php
// views/client/details.php

// 1. Simulation de la BDD (À remplacer plus tard par une vraie requête PDO via $_GET['id'])
$establishment_id = 12; // ID fictif de l'établissement
$establishment_name = "Kribi Beach Resort";
$category = "hotel";
$xml_data_from_db = '<attributes><stars>4</stars><has_pool>Oui</has_pool><has_wifi>Oui</has_wifi></attributes>';

// 2. Lecture du XML
$xml = simplexml_load_string($xml_data_from_db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de <?php echo $establishment_name; ?></title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $establishment_name; ?></h1>
        <p>Catégorie : <strong><?php echo ucfirst($category); ?></strong></p>
        <hr>

        <h3>Caractéristiques spécifiques :</h3>
        <ul class="specifications-list">
            <?php if ($category === 'hotel'): ?>
                <li>⭐ Nombre d'étoiles : <?php echo $xml->stars; ?> étoiles</li>
                <li>🏊 Piscine disponible : <?php echo $xml->has_pool; ?></li>
                <li>📶 Wi-Fi gratuit : <?php echo $xml->has_wifi; ?></li>
            <?php endif; ?>
        </ul>

        <hr>

        <div class="section-avis">
            <h3>Laissez un avis sur cet établissement</h3>
            <div id="zone-reponse"></div> <form id="form-avis">
                <input type="hidden" id="establishment_id" value="<?php echo $establishment_id; ?>"> 

                <label for="rating">Note (sur 5) :</label>
                <select id="rating" required>
                    <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                    <option value="4">⭐⭐⭐⭐ (Très bien)</option>
                    <option value="3">⭐⭐⭐ (Moyen)</option>
                    <option value="2">⭐⭐ (Mauvais)</option>
                    <option value="1">⭐ (Horrible)</option>
                </select>

                <label for="comment">Votre commentaire :</label>
                <textarea id="comment" placeholder="Racontez votre expérience..." required></textarea>

                <button type="submit">Publier l'avis</button>
            </form>
        </div>
    </div>

    <script src="../../public/js/app.js"></script>
</body>
</html>