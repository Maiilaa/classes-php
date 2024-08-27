<?php
session_start();
include 'user.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$localhost = "localhost";
$user = "root";
$password = "";
$database = "classes";

$userObj = new User($localhost, $user, $password, $database);
$userInfo = $userObj->read($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations Utilisateur</title>
</head>
<body>
    <header>
        <?php include  '_header.php';?>
    </header>
    <h2>Informations de l'utilisateur</h2>
    <p>Login: <?php echo htmlspecialchars($userInfo['login']); ?></p>
    <p>Email: <?php echo htmlspecialchars($userInfo['email']); ?></p>
    <p>Prénom: <?php echo htmlspecialchars($userInfo['firstname']); ?></p>
    <p>Nom: <?php echo htmlspecialchars($userInfo['lastname']); ?></p>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
