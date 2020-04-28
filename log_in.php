<?php
	session_start();
	
	if(!isset($_SESSION['logged_User_Id'])){
		if((!isset($_POST['login']))||(!isset($_POST['password'])||(!isset($_POST['email'])))){
			header('Location:index.php');
			exit();
		}
		//echo $_POST['login'].' '.$_POST['password'];
		//echo 'log_in.php';
		require_once 'database.php';
		
		if(isset($_POST['login'])){
			$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
			$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
			$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
			
			$user_Login_Query = $db->prepare('SELECT * FROM users WHERE username =:login');
			$user_Login_Query->bindValue(':login', $login, PDO::PARAM_STR);
			$user_Login_Query->execute();
			
			$user = $user_Login_Query -> fetch();
			
			if(empty($user)) {
				$_SESSION['login_error'] = 'Nie znaleziono podanego loginu';
				header('Location: index.php');
				exit();
			}
			if(empty($email)){
				$_SESSION['email_error'] = 'Błędnie wprowadzony adres email';
				header('Location: index.php');
				exit();
			}
			if($email != $user['email']){
				$_SESSION['email_error'] = 'Błędnie wprowadzony adres email';
				header('Location: index.php');
				exit();
			}
			//print_r($user);
			//$haslo = password_hash($user['password'], PASSWORD_DEFAULT);
			
			if(password_verify($password, $user['password'])){
				$_SESSION['logged_User_Id'] = $user['id'];
				header('Location: main.php');
				echo 'Poprawne logowanie';
			} else {
				//invalid login attempt
				$_SESSION['password_error'] = 'Podano błędne hasło';
				header('Location: index.php');
				exit();
			}
			
		}
		else{
			header('Location: index.php');
			exit();
		}
	}
?>