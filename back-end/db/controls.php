<?php
    require_once("connect.php");
    if($_GET){
        $rol = $_GET['rol'] ?? NULL;
    }
    if($_POST){
        $username = $char->filter($_POST['username']);
        $password = $char->filter($_POST['password']);
        if(isset($username) && isset($password)){
            if($db->user_check("admin",$username,$password)>0){
                if($db->email_check("admin",$username,$password)){
                    $account_info = $db->get("admin","email",$username);
                    $_SESSION['email'] = $username;
                    $_SESSION['username'] = $account_info['username'];
                    $_SESSION['password'] = $password;
                }
                else if($db->username_check("admin",$username,$password)){
                    $account_info = $db->get("admin","username",$username);
                    $_SESSION['email'] = $account_info['email'];
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                }
                header("Location:../../panel/");
            }
            else if($db->user_check("user",$username,$password)>0){
                if($db->email_check("user",$username,$password)){
                    $account_info = $db->get("user","email",$username);
                    $_SESSION['email'] = $username;
                    $_SESSION['username'] = $account_info['username'];
                    $_SESSION['password'] = $password;
                }
                else if($db->username_check("user",$username,$password)){
                    $account_info = $db->get("user","username",$username);
                    $_SESSION['email'] = $account_info['email'];
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                }
                header("Location:../../panel/a.php");
            }
            else{
                if($_GET){
                    if($rol=="admin"){
                        header("Location:../../admin/giris.php?hata=1");
                    }
                    elseif($rol=="user"){
                        header("Location:../../kullanici/giris.php?hata=1");
                    }
                }
                else{
                    header("Location:../../kullanici/giris.php?hata=1");
                }
            }
        }
    }
?>