<?php
session_start();
include 'user-pdo.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login-pdo.php');
    exit();
}

// Gestion de la déconnexion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login-pdo.php"); 
    exit();
}

$localhost = "localhost";
$user = "root";
$password = "";
$database = "classes";

// Création de l'objet User
$userObj = new User($localhost, $user, $password, $database);

// Récupération des informations de l'utilisateur
$userInfo = $userObj->read($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations Utilisateur</title>
    <link rel ="stylesheet" href="Assets/css/index-pdo.css?t=<?=time()?>">
</head>
<body>
    <header>
        <?php include '_header-pdo.php'; ?>
    </header>
    <main> 
        <h2>Informations de l'utilisateur</h2>
        <p>Login: <?php echo htmlspecialchars($userInfo['login']); ?></p>
        <p>Email: <?php echo htmlspecialchars($userInfo['email']); ?></p>
        <p>Prénom: <?php echo htmlspecialchars($userInfo['firstname']); ?></p>
        <p>Nom: <?php echo htmlspecialchars($userInfo['lastname']); ?></p>

        <!-- Formulaire de déconnexion -->
        <form action="infos-pdo.php" method="POST">
            <input type="hidden" name="logout" value="1">
            <input type="submit" value="Se déconnecter">
        </form>
    </main>
</body>
</html>
