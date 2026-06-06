<?php
// views/partner/dashboard.php
session_start();

// 1. Barrière de sécurité stricte : réservé aux partenaires
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'partner') {
    header('Location: ../../auth/login.php');
    exit;
}

require_once '../../config/database.php';

try {
    // 2. Récupération du nom du partenaire (ou de son établissement)
    $stmt = $pdo->prepare('SELECT name FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: ../../auth/logout.php');
        exit;
    }
   
    $partner_name = $user['name'];

    // 3. (Bonus pour plus tard) : Compter le nombre de ressources actives
    // Cette requête sera utile quand la table 'resources' sera bien remplie
    /*
    $stmt_count = $pdo->prepare('SELECT COUNT(*) as total FROM resources WHERE establishment_id = ?');
    $stmt_count->execute([$_SESSION['user_id']]);
    $total_resources = $stmt_count->fetch()['total'];
    */

} catch (\PDOException $e) {
    error_log($e->getMessage());
    $partner_name = "Partenaire";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Partenaire - AllInCam</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
</head>
<body style="background-color: #f4f7f6; font-family: sans-serif; margin: 0;">

    <header style="background-color: #2c3e50; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="margin: 0;">AllInCam | Espace Partenaire</h2>
        </div>
        <nav>
            <a href="../../auth/logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold; background: white; padding: 5px 10px; border-radius: 4px;">Déconnexion</a>
        </nav>
    </header>

    <main style="padding: 30px; max-width: 1200px; margin: 0 auto;">
       
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h1 style="color: #2c3e50; margin-top: 0;">Tableau de bord de <?php echo htmlspecialchars($partner_name); ?></h1>
            <p style="color: #7f8c8d;">Gérez vos annonces, suivez vos réservations et analysez vos revenus depuis cet espace.</p>
        </div>

        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
           
            <div style="flex: 1; min-width: 250px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-top: 4px solid #3498db;">
                <h3 style="margin-top: 0;">Vos Ressources</h3>
                <p>Ajoutez ou modifiez vos chambres, véhicules ou salles.</p>
                <a href="gerer_ressources.php" style="display: inline-block; background: #3498db; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">Accéder à la gestion</a>
            </div>

            <div style="flex: 1; min-width: 250px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-top: 4px solid #2ecc71;">
                <h3 style="margin-top: 0;">Réservations Actives</h3>
                <p style="font-size: 2em; font-weight: bold; color: #2ecc71; margin: 10px 0;">0</p>
                <p style="color: #7f8c8d; font-size: 0.9em;">Aucune réservation pour le moment.</p>
            </div>

            <div style="flex: 1; min-width: 250px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-top: 4px solid #f1c40f;">
                <h3 style="margin-top: 0;">Revenus (Mois en cours)</h3>
                <p style="font-size: 2em; font-weight: bold; color: #f1c40f; margin: 10px 0;">0 FCFA</p>
                <p style="color: #7f8c8d; font-size: 0.9em;">Généré après la taxe de 5%.</p>
            </div>

        </div>

    </main>

</body>
</html>