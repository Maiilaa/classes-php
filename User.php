<?php
class User {

    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $conn;

    // Constructeur pour la connexion à la base de données
    public function __construct($localhost, $user, $password, $classes) {
        $this->conn = new mysqli($localhost, $user, $password, $classes);

        if ($this->conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $this->conn->connect_error);
        }
    }

    // Méthode pour créer un utilisateur
    public function create($login, $password, $email, $firstname, $lastname) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $login, $hashedPassword, $email, $firstname, $lastname);

        if ($stmt->execute()) {
            return "Nouvel utilisateur créé avec succès.";
        } else {
            return "Erreur lors de la création de l'utilisateur : " . $this->conn->error;
        }
    }

    // Méthode pour lire les informations d'un utilisateur
    public function read($id) {
        $sql = "SELECT * FROM utilisateurs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return "Aucun utilisateur trouvé avec cet ID.";
        }
    }

    // Méthode pour connecter un utilisateur
    public function login($login, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login'] = $user['login'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                return true;
            } else {
                return "Mot de passe incorrect.";
            }
        } else {
            return "Utilisateur non trouvé.";
        }
    }

    // Méthode pour déconnecter un utilisateur
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        return "Vous avez été déconnecté.";
    }

    // Méthode pour mettre à jour un utilisateur
    public function update($id, $login, $email, $firstname, $lastname) {
        $sql = "UPDATE utilisateurs SET login = ?, email = ?, firstname = ?, lastname = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $login, $email, $firstname, $lastname, $id);

        if ($stmt->execute()) {
            return "Utilisateur mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour de l'utilisateur : " . $this->conn->error;
        }
    }

    // Méthode pour supprimer un utilisateur
    public function delete($id) {
        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return "Utilisateur supprimé avec succès.";
        } else {
            return "Erreur lors de la suppression de l'utilisateur : " . $this->conn->error;
        }
    }

    // Méthode pour obtenir les informations de l'utilisateur
    public function getUserInfo() {
        return [
            'login' => $this->login,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Utilisateur</title>
</head>
<body>
    <header>
        <?php include  '_header.php';?>
    </header>
    <main>
        <h2>Gestion des Utilisateurs</h2>
        <!-- Formulaire de création d'utilisateur -->
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
    </main>

</body>
</html>
