<?php
class User{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $conn;

    public function __construct($id, $login, $email, $firstname, $lastname){
        $this->conn = new mysqli($localhost, $user, $password, $database);
        $this->conn = new mysqli('localhost', 'root', 'password123', 'classes');

        if ($this->conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $this->conn->connect_error);
        }
    }
        
}
?>
