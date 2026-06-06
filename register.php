<?php
// auth/register.php
session_start();

// Si l'utilisateur est déjà connecté, on le redirige vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../config/database.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    // Récupération et nettoyage des données
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // 'client' ou 'partner'

    // Validation basique
    if (!empty($name) && !empty($email) && !empty($password) && !empty($role)) {
       
        // Validation du format de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Le format de l'adresse email est invalide.";
        } else {
            try {
                // 1. Vérifier si l'email existe déjà dans la base de données
                $check_stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
                $check_stmt->execute([$email]);
               
                if ($check_stmt->rowCount() > 0) {
                    $error_message = "Cette adresse email est déjà utilisée.";
                } else {
                    // 2. Le cœur de la sécurité : le hachage du mot de passe
                    // PASSWORD_DEFAULT utilise actuellement l'algorithme bcrypt, très robuste
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // 3. Insertion sécurisée dans la base de données
                    $insert_stmt = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
                   
                    if ($insert_stmt->execute([$name, $email, $hashed_password, $role])) {
                        $success_message = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                    } else {
                        $error_message = "Une erreur est survenue lors de la création du compte.";
                    }
                }
            } catch (\PDOException $e) {
                error_log($e->getMessage());
                $error_message = "Erreur technique lors de l'inscription.";
            }
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
    <title>Inscription - AllInCam</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/auth.css">
</head>
<body>

    <div class="register-container">
        <h2>Créer un compte AllInCam</h2>
       
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-error" style="color: red; margin-bottom: 15px;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success" style="color: green; margin-bottom: 15px;">
                <?php echo htmlspecialchars($success_message); ?> <br>
                <a href="login.php">Aller à la page de connexion</a>
            </div>
        <?php else: ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="name">Nom complet ou Nom de l'établissement :</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Adresse Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>

                <div class="form-group">
                    <label for="role">Je souhaite m'inscrire en tant que :</label>
                    <select id="role" name="role" required>
                        <option value="client">Client (Pour réserver)</option>
                        <option value="partner">Partenaire (Pour proposer des services)</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">S'inscrire</button>
            </form>
           
            <p style="margin-top: 15px; text-align: center;">
                Déjà un compte ? <a href="login.php">Connectez-vous ici</a>
            </p>

        <?php endif; ?>
    </div>

</body>
</html>