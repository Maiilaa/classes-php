<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si non connecté
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
</head>
<body>

<h2>Bienvenue, <?php echo htmlspecialchars($user['firstname']); ?> !</h2>

<p>Login : <?php echo htmlspecialchars($user['login']); ?></p>
<p>Email : <?php echo htmlspecialchars($user['email']); ?></p>
<p>Prénom : <?php echo htmlspecialchars($user['firstname']); ?></p>
<p>Nom : <?php echo htmlspecialchars($user['lastname']); ?></p>

<a href="logout.php">Se déconnecter</a>

</body>
</html>
