<?php
	session_start();
	
	if(isset($_POST['email'])){
		$successful_validation = true;
		
		$login = $_POST['login'];
		$_SESSION['set_login'] = $login;
		
		if(strlen($login)<3 || strlen($login)>20){
			$successful_validation = false;
			$_SESSION['login_error']="Login musi posiadać od 3 do 20 znaków";
		}
		if(ctype_alnum($login) == false){
			$successful_validation = false;
			$_SESSION['login_error'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		$email = $_POST['email'];
		$_SESSION['set_email'] = $email;
		$email_After_Sanitization = filter_var($email, FILTER_SANITIZE_EMAIL);
		$email_After_Validation = filter_var($email_After_Sanitization, FILTER_VALIDATE_EMAIL);
		
		if(($email_After_Validation == false) || ($email_After_Sanitization != $email)){
			$successful_validation = false;
			$_SESSION['email_error'] = "Podaj poprawny adres email";
		}
		
		$password = $_POST['password'];
		$password_Repeat = $_POST['password2'];
		
		if(strlen($password)<8 || strlen($password)>20){
			$successful_validation = false;
			$_SESSION['password_error'] = "Hasło musi posiadać od 8 do 20 znaków";
		}
		
		if($password != $password_Repeat){
			$successful_validation = false;
			$_SESSION['password_error'] = "Podane hasła nie są identyczne";
		}
		
		if($successful_validation == true){
		
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			
			require_once 'database.php';
			
			try{
				//check if email already exists
				$check_Query = $db->prepare('SELECT id FROM users WHERE email = :email');
				$check_Query->bindValue(':email', $email_After_Validation, PDO::PARAM_STR);
				$check_Query->execute();
				
				$how_many_identical_mails = $check_Query->rowCount();
				
				if($how_many_identical_mails>0){
					$successful_validation = false;
					$_SESSION['email_error'] = "Istnieje już konto przypisane do tego adresu e-mail";
				}
				
				//check if login already exists
				$check_Query = $db->prepare('SELECT id FROM users WHERE username = :login');
				$check_Query->bindValue(':login', $login, PDO::PARAM_STR);
				$check_Query->execute();
				
				$how_many_identical_logins = $check_Query->rowCount();
				
				if($how_many_identical_logins>0){
					$successful_validation = false;
					$_SESSION['login_error'] = "Istnieje już konto o podanym loginie";
				}
				
				if($successful_validation == true){
					unset($_SESSION['set_email']);
					unset($_SESSION['set_login']);
					$insert_Query = $db->prepare('INSERT INTO users VALUES (NULL, :username, :password, :email)');
					$insert_Query->bindValue(':username', $login, PDO::PARAM_STR);
					$insert_Query->bindValue(':password', $password_hash, PDO::PARAM_STR);
					$insert_Query->bindValue(':email', $email_After_Validation, PDO::PARAM_STR);
					$insert_Query->execute();
					
					$check_Query = $db->prepare('SELECT id FROM users WHERE username = :login');
					$check_Query->bindValue(':login', $login, PDO::PARAM_STR);
					$check_Query->execute();
					
					$result = $check_Query->fetch();
					
					$user_id = $result['id'];
					
					$insert_Query2 = $db->exec("INSERT INTO expenses_category_assigned_to_users VALUES (null, '$user_id','Jedzenie'),(null, '$user_id', 'Mieszkanie'),(null, '$user_id','Transport'),(null, '$user_id','Telekomunikacja'),(null, '$user_id','Opieka zdrowotna'),(null, '$user_id','Ubranie'),(null, '$user_id','Higiena'),(null, '$user_id','Dzieci'),(null, '$user_id','Rozrywka'),(null, '$user_id','Wycieczka'),(null, '$user_id','Szkolenia'),(null, '$user_id','Książki'),(null, '$user_id','Oszczędności'),(null, '$user_id','Darowizna'),(null, '$user_id','Spłata długów'),(null, '$user_id','Na złotą jesien, czyli emeryturę'),(null, '$user_id','Inne wydatki')");
					
					$insert_Query3 = $db->exec("INSERT INTO incomes_category_assigned_to_users VALUES (null, '$user_id','Wynagrodzenie'),(null, '$user_id','Odsetki bankowe'),(null, '$user_id','Sprzedaż na Allegro'),(null, '$user_id','Inne źródło')");
					
					$insert_Query4 = $db->exec("INSERT INTO payment_methods_assigned_to_users VALUES (null, '$user_id','Gotówka'),(null, '$user_id','Karta Debetowa'),(null, '$user_id','Karta Kredytowa');");
					/*if($insert_Query == true){
						$_SESSION['successful_registration']=true;
						echo 'zarejestrowałeś się - oooooooooooo';
						//header('Location:main.php');
					}*/
				}
				
			}
			catch(PDOException $e){
				echo "<span style=\"color:red;\">". $e->getCode().'  '. $e->getMessage().'</span><br/>'; 
				echo "<span style=\"color:red;\">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestracje w innym terminie!</span>";
			}
		}
	}
	
?>
<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Bezpożyczek.pl</title>
	<meta name="description" content="Aplikacja internetowa służąca do planowania domowego budżetu">
	<meta name="keywords" content="budżet, wydatki, przychody, pieniądze, bilans, zarzadzanie, aplikacja, internetowa">
	<meta name="author" content="Kamil Szela">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!--Bootstrap CSS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<!--Bootstrap CSS-->
	
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div class="container mt-3 rounded h-100">
	
		<header id="appHeader" class="row bg-secondary align-items-center text-center justify-content-center px-3 py-2">
			<h3><b>Bezpożyczek.pl - aplikacja internetowa wspomagająca zażądzanie funduszami</b></h3>
		</header>
		<div class="row custom-bg py-2 align-items-center justify-content-center">
			<p class="font-2rem mt-3 mr-3 ml-3 text-center">Aby zarejestrowac się jako użytkownik wypełnij poniższy formularz</p>
			<div class="col-sm-10 align-self-center h-register" id="userDataGroup">
			<form method="post">
				<div class="input-group mb-4">
					<div class="input-group-prepend">
						<span class="fa fa-user input-group-text fa-22-font pt-11"></span>
					</div>
					<input class="form-control form-control-lg" type="text" name="login" placeholder="Login" 
					<?=
						isset($_SESSION['set_login'])?
							 'value="'.$_SESSION['set_login'].'"' : ''
					?>></input>
				</div>
				<?php
					if(isset($_SESSION['login_error'])){
						echo '<p class="text-danger">'.$_SESSION['login_error'].'</p>';
						unset($_SESSION['login_error']);
					}
				?>
				<div class="input-group mb-4">
					<div class="input-group-prepend">
						<span class="input-group-text fa fa-key fa-22-font pt-11"></span>
					</div>
					<input class="form-control form-control-lg" type="password" name="password" placeholder="Hasło"></input>
				</div>
				
				<div class="input-group mb-4">
					<div class="input-group-prepend">
						<span class="input-group-text fa fa-key fa-22-font pt-11"></span>
					</div>
					<input class="form-control form-control-lg" type="password" name="password2" placeholder="Powtórz hasło"></input>
				</div>
				<?php
					if(isset($_SESSION['password_error'])){
						echo '<p class="text-danger">'.$_SESSION['password_error'].'</p>';
						unset($_SESSION['password_error']);
					}
				?>
				<div class="input-group mb-4">
					<div class="input-group-prepend">
						<span class="input-group-text fa fa-envelope fa-22-font pt-11"></span>
					</div>
					<input class="form-control form-control-lg" type="text" name="email" placeholder="Email" 
					<?=
						isset($_SESSION['set_email'])?
							 'value="'.$_SESSION['set_email'].'"' : ''
					?>
					></input>
				</div>
				<?php
					if(isset($_SESSION['email_error'])){
						echo '<p class="text-danger">'.$_SESSION['email_error'].'</p>';
						unset($_SESSION['email_error']);
					}
				?>
				<div class="col-sm-12 text-center text-danger mb-2" id="loginFunctionMessage"></div>
				<input id="signUp" type="submit" class="btn btn-primary btn-block mb-2" value="Zarejestruj się"></input> 
			</form>		
			</div>
			<div class="col-sm-12">
				<a href="https://pl.freepik.com/darmowe-zdjecie-wektory/pieniadze" class="text-muted pull-right push-down text-sm">Grafika w tle autorstwa natanaelginting - pl.freepik.com</a>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!--Bootstrap-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	
	<body>
	<html>