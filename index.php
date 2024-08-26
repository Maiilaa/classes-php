<?php
require_once 'User.php';

// Connection to database
$user = new User('localhost', 'root', '', 'classes');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Utilisateur</title>
</head>
<body>

<!-- Form for create an user-->
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

<?php
// Treatement for creation
if (isset($_POST['create'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    echo $user->create($login, $password, $email, $firstname, $lastname);
}
?>

<hr>

<!-- Form for read an user-->
<form action="index.php" method="GET">
    <h3>Lire les informations d'un utilisateur</h3>
    <label for="id">ID de l'utilisateur:</label>
    <input type="number" id="id" name="id" required><br><br>

    <input type="submit" name="read" value="Lire les informations">
</form>

<?php
// Treatment for the reading
if (isset($_GET['read'])) {
    $id = $_GET['id'];
    $result = $user->read($id);
    if (is_array($result)) {
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } else {
        echo $result;
    }
}
?>

<hr>

<!-- Form for update an user -->
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

<?php
// Treatment for the update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    echo $user->update($id, $login, $email, $firstname, $lastname);
}
?>

<hr>

<!-- Form for delete an user-->
<form action="index.php" method="POST">
    <h3>Supprimer un utilisateur</h3>
    <label for="id">ID de l'utilisateur à supprimer:</label>
    <input type="number" id="id" name="id" required><br><br>

    <input type="submit" name="delete" value="Supprimer l'utilisateur">
</form>

<?php
// Treatment for delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    echo $user->delete($id);
}
?>

</body>
</html>
