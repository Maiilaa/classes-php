<?php
class User{

    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $conn;

    public function __construct($localhost, $user, $password, $classes){
        $this->conn = new mysqli($localhost, $user, $password, $classes);
        

        if ($this->conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $this->conn->connect_error);
        }
    }
        
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

    
    public function __destruct() {
        $this->conn->close();
    }
}


?>
