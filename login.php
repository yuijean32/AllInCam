<?php
// auth/login.php
session_start(); // Obligatoire pour utiliser les sessions ($_SESSION)

// Si l'utilisateur est déjà connecté, on le redirige directement pour éviter qu'il se reconnecte
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Inclusion du fichier de connexion
require_once '../config/database.php';

$error_message = '';

// Traitement du formulaire uniquement lors de la soumission en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    // Nettoyage des données pour éviter les espaces inutiles
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
       
        try {
            // 1. Requête préparée pour récupérer l'utilisateur par son email
            $stmt = $pdo->prepare('SELECT id, password, role FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // 2. Vérification de l'existence de l'utilisateur et du hachage du mot de passe
            if ($user && password_verify($password, $user['password'])) {
               
                // Régénération de l'ID de session pour contrer les attaques de fixation de session
                session_regenerate_id(true);

                // Enregistrement des informations essentielles en session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role']    = $user['role'];

                // 3. Routage dynamique selon le rôle enregistré dans la base de données
                switch ($user['role']) {
                    case 'admin':
                        header('Location: ../views/admin/dashboard.php');
                        break;
                    case 'partner':
                        header('Location: ../views/partner/dashboard.php');
                        break;
                    case 'client':
                    default:
                        header('Location: ../views/client/accueil.php');
                        break;
                }
                exit; // Interrompt le script après une redirection

            } else {
                // Message générique pour ne pas indiquer si c'est le mail ou le mot de passe qui est faux (sécurité)
                $error_message = "Identifiants incorrects.";
            }

        } catch (\PDOException $e) {
            error_log($e->getMessage());
            $error_message = "Une erreur est survenue lors de l'authentification.";
        }

    } else {
        $error_message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - AllInCam</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/auth.css">
</head>
<body>

    <div class="login-container">
        <h2>Connexion à AllInCam</h2>
       
        <?php if (!empty($error_message)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Adresse Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </div>

</body>
</html>