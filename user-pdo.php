<?php

class Userpdo {
    private $pdo;
    private $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $isConnected = false;

    // Constructeur : Initialise la connexion à la base de données
    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=your_database_name', 'username', 'password');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Enregistre un nouvel utilisateur dans la base de données
    public function register($login, $password, $email, $firstname, $lastname) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$login, $hashedPassword, $email, $firstname, $lastname]);

        $this->id = $this->pdo->lastInsertId();
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
        ];
    }

    // Connecte un utilisateur avec son login et mot de passe
    public function connect($login, $password) {
        $sql = "SELECT * FROM utilisateurs WHERE login = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$login]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            $this->isConnected = true;

            return true;
        }
        return false;
    }

    // Déconnecte l'utilisateur
    public function disconnect() {
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->isConnected = false;
    }

    // Supprime un utilisateur et le déconnecte
    public function delete() {
        if ($this->isConnected) {
            $sql = "DELETE FROM utilisateurs WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$this->id]);

            $this->disconnect();
        }
    }

    // Met à jour les informations de l'utilisateur
    public function update($login, $password, $email, $firstname, $lastname) {
        if ($this->isConnected) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "UPDATE utilisateurs SET login = ?, password = ?, email = ?, firstname = ?, lastname = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$login, $hashedPassword, $email, $firstname, $lastname, $this->id]);

            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
        }
    }

    // Vérifie si l'utilisateur est connecté
    public function isConnected() {
        return $this->isConnected;
    }

    // Récupère toutes les informations de l'utilisateur connecté
    public function getAllInfos() {
        if ($this->isConnected) {
            return [
                'id' => $this->id,
                'login' => $this->login,
                'email' => $this->email,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
            ];
        }
        return null;
    }

    // Retourne le login de l'utilisateur
    public function getLogin() {
        return $this->login;
    }

    // Retourne l'email de l'utilisateur
    public function getEmail() {
        return $this->email;
    }

    // Retourne le prénom de l'utilisateur
    public function getFirstname() {
        return $this->firstname;
    }

    // Retourne le nom de famille de l'utilisateur
    public function getLastname() {
        return $this->lastname;
    }
}
