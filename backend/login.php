<?php
session_start();
require_once("dbconn.php");
if (isset($_SESSION["valid"]))
{
    header("Location:../index.php");
}
//Msg variables
$msg = '';
$msgClass = '';
if (filter_has_var(INPUT_POST, 'submit'))
{
    $username = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);

    $sql = "SELECT `uid`, `username`, `password`, `email` FROM `user` WHERE uid=$username";
    $res = $pdo->prepare($sql);
    $res->execute();
    $ans = $res->fetchAll(PDO::FETCH_OBJ);
    
    if(password_verify($pass, $ans["password"]))
    {
        $_SESSION["uid"] = $ans["uid"];
        $_SESSION["valid"] = true;
        header("Location:../index.php");
    }
}
?>