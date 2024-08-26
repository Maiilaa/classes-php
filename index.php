<?php
require_once 'User.php';
session_start();

// Connexion à la base de données via la classe User
$user = new User('localhost', 'root', '', 'classes');

// Traitement des actions (création, lecture, mise à jour, suppression)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Créer un utilisateur
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        // Hashage du mot de passe pour la sécurité
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Création de l'utilisateur
        $message = $user->create($login, $passwordHash, $email, $firstname, $lastname);
        echo "<p>$message</p>";
    }

    if (isset($_POST['update'])) {
        // Mise à jour d'un utilisateur
        $id = $_POST['id'];
        $login = $_POST['login'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $message = $user->update($id, $login, $email, $firstname, $lastname);
        echo "<p>$message</p>";
    }

    if (isset($_POST['delete'])) {
        // Suppression d'un utilisateur
        $id = $_POST['id'];
        $message = $user->delete($id);
        echo "<p>$message</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['read'])) {
    // Lire les informations d'un utilisateur
    $id = $_GET['id'];
    $result = $user->read($id);
    if (is_array($result)) {
        echo "<h3>Informations de l'utilisateur</h3>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } else {
        echo "<p>$result</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Utilisateur</title>
</head>
<body>

<h2>Gestion des Utilisateurs</h2>

<!-- Formulaire de création d'utilisateur -->
<form action="index.php" method="POST">
    <h3>Créer un utilisateur</h3>
    <label for="login">Login:</label>
    <input type="text" id="login" name="login" required><br><br>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="firstname">Prénom:</label>
    <input type="text" id="firstname" name="firstname" required><br><br>

    <label for="lastname">Nom:</label>
    <input type="text" id="lastname" name="lastname" required><br><br>

    <input type="submit" name="create" value="Créer l'utilisateur">
</form>

<hr>

<!-- Formulaire de lecture d'utilisateur -->
<form action="index.php" method="GET">
    <h3>Lire les informations d'un utilisateur</h3>
    <label for="id">ID de l'utilisateur:</label>
    <input type="number" id="id" name="id" required><br><br>

    <input type="submit" name="read" value="Lire les informations">
</form>

<hr>

<!-- Formulaire de mise à jour d'utilisateur -->
<form action="index.php" method="POST">
    <h3>Mettre à jour un utilisateur</h3>
    <label for="id">ID de l'utilisateur:</label>
    <input type="number" id="id" name="id" required><br><br>

    <label for="login">Nouveau login:</label>
    <input type="text" id="login" name="login" required><br><br>

    <label for="email">Nouvel email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="firstname">Nouveau prénom:</label>
    <input type="text" id="firstname" name="firstname" required><br><br>

    <label for="lastname">Nouveau nom:</label>
    <input type="text" id="lastname" name="lastname" required><br><br>

    <input type="submit" name="update" value="Mettre à jour l'utilisateur">
</form>

<hr>

<!-- Formulaire de suppression d'utilisateur -->
<form action="index.php" method="POST">
    <h3>Supprimer un utilisateur</h3>
    <label for="id">ID de l'utilisateur à supprimer:</label>
    <input type="number" id="id" name="id" required><br><br>

    <input type="submit" name="delete" value="Supprimer l'utilisateur">
</form>

</body>
</html>
