<?php
session_start();    
include 'user.php';

$localhost = "localhost";
$user = "root";
$password = "";
$database = "classes";
$userObj = new User($localhost, $user, $password, $database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $result = $userObj->login($_POST['login'], $_POST['password']);
        if ($result === true) {
            header('Location: infos.php');
            exit();
        } else {
            echo $result;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
    <link rel ="stylesheet" href="Assets/css/index-pdo.css">
</head>
<body>
    <header>
        <?php include  '_header-pdo.php';?>
    </header>
    <main>
        <h2>Connexion</h2>
        <form action="login.php" method="POST">
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" required><br><br>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" name="login_submit" value="Se connecter">
        </form>
    </main>
</body>
</html>
