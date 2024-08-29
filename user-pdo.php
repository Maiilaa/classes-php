<?php
class User {
    private $pdo;
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function connect($login, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            return true;
        }
        return false;
    }

    public function connectById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->id = $user['id'];
            $this->login = $user['login'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            return true;
        }
        return false;
    }

    public function update($login, $password, $email, $firstname, $lastname) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE utilisateurs SET login = ?, password = ?, email = ?, firstname = ?, lastname = ? WHERE id = ?");
        $stmt->execute([$login, $hashedPassword, $email, $firstname, $lastname, $this->id]);
        return $stmt->rowCount() > 0;
    }

    public function delete() {
        $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
        $stmt->execute([$this->id]);
        return $stmt->rowCount() > 0;
    }

    public function register($login, $password, $email, $firstname, $lastname) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$login, $hashedPassword, $email, $firstname, $lastname]);

        $this->id = $this->pdo->lastInsertId();
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        return true;
    }

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }
}
?>