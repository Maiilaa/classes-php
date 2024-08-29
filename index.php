<?php
include 'user.php';


$localhost = "localhost";
$user = "root";
$password = ""; 
$database = "classes";

try {
    $userObj = new User($localhost, $user, $password, $database);
} catch (mysqli_sql_exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        echo $userObj->create($_POST['login'], $_POST['password'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
    } elseif (isset($_POST['update'])) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            echo $userObj->update($_POST['id'], $_POST['login'], $_POST['email'], $_POST['firstname'], $_POST['lastname']);
        } else {
            echo "Erreur : ID manquant pour la mise à jour.";
        }
    } elseif (isset($_POST['delete'])) {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            echo $userObj->delete($_POST['id']);
        } else {
            echo "Erreur : ID manquant pour la suppression.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
    <link rel ="stylesheet" href="Assets/css/index.css?t=<?=time()?>">
</head>
<body>
    <?php include_once '_header.php'; ?>
    <main>
        <h1>Welcome to my Web Site</h1>
    </main>
</body>
</html>
