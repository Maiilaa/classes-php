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
        <h2>Créer un utilisateur</h2>
        <!-- Formulaire de création d'utilisateur -->
        <form action="index.php" method="POST">
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

            <input type="submit" name="create" value="Créer">
        </form>
    </main>

</body>
</html>
