<?php
session_start(); // Démarrer la session

require_once 'User.php'; // Inclure la classe User

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user'])) {
    header("Location: infos.php"); // Rediriger vers la page d'infos si déjà connecté
    exit;
}

// Connexion à la base de données
$user = new User('localhost', 'root', '', 'classes');

// Traitement du formulaire de connexion
if (isset($_POST['login_submit'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Appel de la méthode pour vérifier les informations de connexion
    $loggedInUser = $user->login($login, $password);

    if ($loggedInUser) {
        // Si l'utilisateur est trouvé, on démarre la session
        $_SESSION['user'] = $loggedInUser; // Stocker l'utilisateur dans la session
        header("Location: infos.php"); // Rediriger vers une page protégée (infos.php ou dashboard)
        exit;
    } else {
        $error = "Identifiants incorrects. Veuillez vérifier votre login et mot de passe.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<?php
// Affichage du message d'erreur s'il y en a un
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>

<form action="login.php" method="POST">
    <label for="login">Login :</label>
    <input type="text" id="login" name="login" required><br><br>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" name="login_submit" value="Se connecter">
</form>

</body>
</html>
