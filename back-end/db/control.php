<?php
    require_once("connect.php");
    if($_POST){
        $email = $char->filter($_POST['email']);
        $password = $char->filter($_POST['password']);
        if(isset($email) && isset($password)){
            if($db->user_check($email,$password)>0){
                if($db->email_check($email,$password)){
                    $account_info = $db->get("users","email",$email);
                    $_SESSION['email'] = $email;
                    $_SESSION['username'] = $account_info['username'];
                    $_SESSION['password'] = $password;
                }
                else if($db->username_check($email,$password)){
                    $account_info = $db->get("users","username",$email);
                    $_SESSION['email'] = $account_info['email'];
                    $_SESSION['username'] = $email;
                    $_SESSION['password'] = $password;
                }
                header("Location:../index.php");
            }
            else{
                header("Location:../login.php?hata=1");
            }
        }
    }
?>