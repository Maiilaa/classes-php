<?php
// Inclure la connexion à la base de données
include 'user-pdo.php'; // Ce fichier doit contenir la logique de connexion PDO

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Préparer et exécuter la requête d'insertion dans la base de données
        try {
            $sql = "INSERT INTO users (login, email, password) VALUES (:login, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            
            // Exécuter la requête
            if ($stmt->execute()) {
                echo "Inscription réussie !";
                // Rediriger ou afficher un message de confirmation
            } else {
                echo "Erreur lors de l'inscription.";
            }
        } catch (PDOException $e) {
            echo "Erreur de base de données : " . $e->getMessage();
        }
    } else {
        echo "Tous les champs sont obligatoires.";
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
    <?php include_once '_header-pdo.php'; ?>
    <main>
        <h1>Inscription</h1>
        
        <form method="POST" action="register-pdo.php">
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
        <p><a href="login-pdo.php">Déjà inscrit? Connectez-vous ici.</a></p>
    </main>
</body>
</html>


