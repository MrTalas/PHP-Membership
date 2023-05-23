<?php
	session_start();
	include("../back-end/function/func.php");
	$db = new db();
	$char = new char();
	$user = new user();
	$db->connect("localhost","uyelik","root","");


	function sifre_uret($length,$row)
	{
		$veri = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$veri .= "abcdefghijklmnopqrstuvwxyz";
		$veri .= "0123456789";

		$all_password = "";
		for($i=1;$i<=$row;$i++){
			$password = "";
			
			while(strlen($password) < $length)
			{
				$password .= substr($veri,(rand() % strlen($veri)),1);
			}
			$all_password .= $password;
		}
		return($all_password);
	}


	$username = sifre_uret(8,1);
	$password = sifre_uret(8,1);
	$username = str_replace(" ","",$username);
    $password = str_replace(" ","",$password);

	$db->add_user("user",$username,$password,"default","1","0");
	header("Location:giris.php?username=$username&password=$password");
	
?>