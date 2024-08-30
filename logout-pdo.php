<?php
session_start();
include 'user-pdo.php'; // Inclut le fichier contenant la classe User

$localhost = "localhost";
$user = "root";
$password = "";
$database = "classes";

// Créer une instance de la classe User avec PDO
$userObj = new User($localhost, $user, $password, $database);

// Vérification de la session active
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Récupère l'ID de l'utilisateur connecté

    // Enregistrer l'heure de déconnexion dans la base de données
    $userObj->recordLogout($user_id);

    // Détruire la session
    session_unset(); // Efface toutes les variables de session
    session_destroy(); // Détruit la session
    
    echo "Vous avez été déconnecté avec succès.";
} else {
    echo "Aucune session active à déconnecter.";
}

// Rediriger vers la page de connexion
header('Location: login-pdo.php');
exit();
?>
