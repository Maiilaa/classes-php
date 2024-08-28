<?php
session_start();    
include 'user.php';

$localhost = "localhost";
$user = "root";
$password = "";
$database = "classes";
$userObj = new User($localhost, $user, $password, $database);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
</head>
<body>
    <header>
        <?php include  '_header.php';?>
    </header>
    <main>
        <h2>Modifier ou Supprimer</h2>
        <form action="index.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
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

            <input type="submit" name="update" value="modifier">
            <input type="submit" name="delete" value="supprimer">
        </form>
    </main>

</body>
</html>