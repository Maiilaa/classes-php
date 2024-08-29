<?php
require_once 'user-pdo.php';

// Connexion à la base de données avec PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classes";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion-pdo.php'); // Rediriger vers la page de connexion si non connecté
    exit();
}

// Récupérer l'utilisateur connecté depuis la base de données
$user_id = $_SESSION['user_id'];
$user = new User($pdo);
$user->connectById($user_id);

// Initialiser la variable pour le message de confirmation
$message = "";

// Vérifier si le formulaire de suppression est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Supprimer l'utilisateur
        if ($user->delete()) {
            // Détruire la session après la suppression
            session_destroy();
            header('Location: connexion-pdo.php'); // Rediriger après la suppression
            exit();
        } else {
            $message = "Erreur lors de la suppression de votre compte.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer le compte utilisateur</title>
</head>
<body>
    <h2>Supprimer le compte</h2>

    <!-- Afficher le message de confirmation -->
    <?php if ($message): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
        <button type="submit" name="delete">Supprimer mon compte</button>
    </form>

    <p><a href="modifier-pdo.php">Retour</a></p>
</body>
</html>