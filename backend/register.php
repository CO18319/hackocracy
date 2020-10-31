<?php
session_start();
require_once("dbconn.php");
if (isset($_SESSION["valid"]))
{
    header("Location:../index.php");
}

if (filter_has_var(INPUT_POST, 'submit')) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $pass = htmlspecialchars($_POST['password']);
    $password = password_hash($pass, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `user`(`username`, `password`, `email`) VALUES ($username,$password,$email)";
    if($conn->exec($sql)) {
        $_SESSION["uid"] = $ans["uid"];
        $_SESSION["valid"] = true;
        header("Location:../index.php");
    }

    header("Location:../index.php");
}