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
//if (!isset($_SESSION['user_id'])) {
    //header('Location: connexion-pdo.php'); // Rediriger vers la page de connexion si non connecté
    //exit();
//}

// Récupérer l'utilisateur connecté depuis la base de données
$user_id = $_SESSION['id'];
$user = new User($pdo);
$user->connectById($user_id);

// Initialiser la variable pour le message de confirmation
$message = "";

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Mettre à jour les informations de l'utilisateur
    if ($user->update($login, $password, $email, $firstname, $lastname)) {
        $message = "Vos informations ont bien été mises à jour !";
        // Recharger les nouvelles données utilisateur
        $user->connectById($user_id);
    } else {
        $message = "Aucune modification n'a été effectuée.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les informations de l'utilisateur</title>
</head>
<body>
    <h2>Modifier les informations</h2>
    <form method="POST" action="">
        <div>
            <label for="login">Login</label>
            <input type="text" id="login" name="login">
        </div>
        <div>
            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" >
        </div>
        <div>
            <label for="firstname">Prénom:</label>
            <input type="text" id="firstname" name="firstname" >
        </div>
        <div>
            <label for="lastname">Nom:</label>
            <input type="text" id="lastname" name="lastname" >
        </div>
        <button type="submit">Mettre à jour</button>
    </form>

    <p><a href="deconnexion.php">Déconnexion</a></p>
    <p><a href="supprimer-pdo.php">Supprimer mon compte</a></p>
</body>
</html>