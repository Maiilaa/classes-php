<?php
session_start();
require_once 'user-pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new Userpdo();
    
    if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        $userData = $user->register($_POST['login'], $_POST['password'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
        $_SESSION['user'] = $userData;
        header('Location: infos.php');
        exit();
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <main>
        <h1>Inscription</h1>
        <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST" action="register.php">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required><br>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="firstname">Prénom:</label>
            <input type="text" id="firstname" name="firstname" required><br>
            <label for="lastname">Nom:</label>
            <input type="text" id="lastname" name="lastname" required><br>
            <input type="submit" value="S'inscrire">
        </form>
        <p><a href="login.php">Déjà inscrit? Connectez-vous ici.</a></p>
    </main>
</body>
</html>
