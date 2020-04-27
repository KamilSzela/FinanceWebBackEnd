<?php
	session_start();
	
	//if((!isset($_POST['login']))||(!isset($_POST['password']))){
		//header('Location:index.php');
		//exit();
	//}
	echo $_POST['login'].' '.$_POST['password'];
	echo 'log_in.php';
	//require_once 'database.php';

	
?>