<?php
    require_once("connect.php");
    $user->account = $db->get("users","username",$user->getSession("username"));
    if($_POST){
        $title =  $_POST['title'] ?? NULL;
        $content = $_POST['content'] ?? NULL;
        if(isset($title) && isset($content)){
            
        }
    }
?>