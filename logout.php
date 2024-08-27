<?php
session_start();
include 'user.php';

$localhost = "localhost";
$user = "root";
$password = "";
$database = "classes";

$userObj = new User($localhost, $user, $password, $database);
echo $userObj->logout();

header('Location: login.php');
?>
