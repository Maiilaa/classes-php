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
        // Requête pour vérifier le login
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Vérifier si le mot de passe est correct
            if (password_verify($password, $user['password'])) {
                // Enregistrer les informations de l'utilisateur dans la session
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
        session_unset(); // Supprime toutes les variables de session
        session_destroy(); // Détruit la session
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

    // Fermeture de la connexion à la base de données
    public function __destruct() {
        $this->conn->close();
    }
}
?>
