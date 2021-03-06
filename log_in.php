<?php
	session_start();
	
	if(!isset($_SESSION['logged_User_Id'])){
		if((!isset($_POST['login']))||(!isset($_POST['password'])||(!isset($_POST['email'])))){
			header('Location:index.php');
			exit();
		}
		if($_POST['login']==""||$_POST['password']==""||$_POST['email']==""){
			$_SESSION['login_error']="Nie wprowadzono wszystkich wymaganych danych";
			header('Location: index.php');
			exit();
		}
		//echo $_POST['login'].' '.$_POST['password'];
		//echo 'log_in.php';
		require_once 'database.php';
		
		if(isset($_POST['login'])){
			$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
			$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
			$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
			$_SESSION['set_login'] = $login;
			$_SESSION['set_email'] = $email;
			
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
				$_SESSION['set_email'] = $email;
				$_SESSION['email_error'] = 'Błędnie wprowadzony adres email';
				header('Location: index.php');
				exit();
			}
			//print_r($user);
			//$haslo = password_hash($user['password'], PASSWORD_DEFAULT);
			
			if(password_verify($password, $user['password'])){
				$_SESSION['logged_User_Id'] = $user['id'];
				unset($_SESSION['set_email']);
				unset($_SESSION['set_login']);
				header('Location: main.php');
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
	else{
		//header('Location: main.php');
		//echo $_SESSION['logged_User_Id'].'coooooooo';
		exit();
	}
?>