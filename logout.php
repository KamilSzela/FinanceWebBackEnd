<?php
	session_start();

	unset($_SESSION['logged_User_Id']);
	header('Location: index.php');
?>