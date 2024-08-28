<?php
session_start();
require_once 'user-pdo.php';

$user = new Userpdo();
$loggedIn = isset($_SESSION['user']) && $user->isConnected();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <link rel ="stylesheet" href="Assets/css/index-pdo.css">
</head>
<body>
    <?php include_once '_header-pdo.php'; ?>
    <main>
        <h1>Bienvenue sur notre site</h1>
        <?php if ($loggedIn): ?>
            <p>Bonjour, <?= htmlspecialchars($_SESSION['user']['firstname']) ?> <?= htmlspecialchars($_SESSION['user']['lastname']) ?>!</p>
            <p><a href="infos-pdo.php">Voir vos informations</a></p>
            <p><a href="modifier-pdo.php">Modifier vos informations</a></p>
            <p><a href="logout-pdo.php">Déconnexion</a></p>
        <?php else: ?>
            <p><a href="register-pdo.php">S'inscrire</a></p>
            <p><a href="login-pdo.php">Se connecter</a></p>
        <?php endif; ?>
    </main>
</body>
</html>
