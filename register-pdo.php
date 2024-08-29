<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
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


