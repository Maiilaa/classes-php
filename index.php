<?php
include 'user.php';

// Créer une instance de la classe User
$localhost = "localhost"; // ou l'adresse IP du serveur MySQL
$user = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$database = "classes"; // Nom de la base de données

$userObj = new User($localhost, $user, $password, $database);

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        echo $userObj->create($_POST['login'], $_POST['password'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
    } elseif (isset($_POST['update'])) {
        echo $userObj->update($_POST['id'], $_POST['login'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
    } elseif (isset($_POST['delete'])) {
        echo $userObj->delete($_POST['id']);
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include_once '_header.php'; ?>
    <main>
        <h1>Welcome to my Web Site</h1>
    </main>
</body>
</html>
