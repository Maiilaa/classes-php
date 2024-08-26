<?php
class User{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $conn;
    
    public function __construct($id, $login, $email, $firstname, $lastname){
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }
}
?>
