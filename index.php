<?php
    session_start();
    include("back-end/function/func.php");
    $db = new db();
    $char = new char();
    $user = new user();
    $db->connect("localhost","uyelik","root","");

    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        if($db->user_check("admin",$_SESSION['username'],$_SESSION['password'])>0){
            header("Location:panel/pages/dashboard.php");  
        }
        else{
            header("Location:kullanici/giris.php");
        }
    }
    else{
        header("Location:kullanici/giris.php");
    }
?>