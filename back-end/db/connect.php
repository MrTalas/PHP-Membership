<?php
    session_start();
    include("../function/func.php");
    $db = new db();
    $char = new char();
    $user = new user();
    $db->connect("localhost","uyelik","root","");
?>