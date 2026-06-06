<?php
// views/client/accueil.php
session_start();

// 1. Vérification de sécurité : l'utilisateur est-il connecté et est-il un client ?
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    // Si ce n'est pas le cas, retour immédiat à la page de connexion
    header('Location: ../../auth/login.php');
    exit;
}

// 2. Connexion à la base de données pour récupérer les infos du client
require_once '../../config/database.php';

try {
    // Requête préparée pour récupérer le nom de l'utilisateur connecté
    $stmt = $pdo->prepare('SELECT name FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // Si l'utilisateur n'existe pas (cas rare d'un compte supprimé entre-temps)
    if (!$user) {
        header('Location: ../../auth/logout.php');
        exit;
    }
   
    $client_name = $user['name'];

} catch (\PDOException $e) {
    error_log($e->getMessage());
    $client_name = "Cher client"; // Valeur de secours en cas de bug de base de données
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Client - AllInCam</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

    <header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef;">
        <div class="logo">
            <strong>AllInCam</strong>
        </div>
        <nav>
            <a href="mes_reservations.php" style="margin-right: 15px; text-decoration: none; color: #333;">Mes Réservations</a>
            <a href="../../auth/logout.php" style="color: red; text-decoration: none; font-weight: bold;">Se déconnecter</a>
        </nav>
    </header>

    <main style="padding: 20px; max-width: 1200px; margin: 0 auto;">
       
        <section class="welcome-message" style="margin-bottom: 30px;">
            <h1>Bienvenue, <?php echo htmlspecialchars($client_name); ?> ! 👋</h1>
            <p>Trouvez et réservez votre prochaine ressource en quelques clics.</p>
        </section>

        <section class="search-box" style="padding: 20px; background-color: #f1f3f5; border-radius: 8px;">
            <h3>Que recherchez-vous aujourd'hui ?</h3>
            <p style="color: #6c757d; font-style: italic;">Le moteur de recherche et l'affichage des ressources seront intégrés ici.</p>
        </section>

    </main>

</body>
</html>