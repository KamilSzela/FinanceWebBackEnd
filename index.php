<?php
	session_start();
	if(isset($_SESSION['logged_User_Id'])){
		header('Location:main.php');
		exit();
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
		<div class="row custom-bg py-2" id="register">
			<div class="col-lg-8 col-md-6 col-sm-12 align-self-center" id="frontDescription">
				
				<h4 class="my-5"><b>Już dziś zacznij kontrolować swoje wydatki!</b></h4>
				
				<p class="text-justify">Pierwszym nawykiem, który jest niezbędny do sprawnego zarządzania swoim budżetem jest umiejętne archiwizowanie swoich wydatków. Niestety może być to żmudne i uciążliwe, zwłaszcza używając tradycyjnej metody z kartka papieru i kalkulatorem.
				Używając tej aplikacji będziesz mógł zrobić to znacznie szybciej i bez zbędnego pogrubiania swoich teczek z dokumentami. 
				Historia wszystkich twoich wydatków będzie w jednym miejscu, bezpieczna i usystematyzowana. Da Ci to komfort planowania i pozwoli od razu zauważyć trendy w swoich wydatkach.</p>

				<p>Za pomocą tej aplikacji:</p>
				<ul class="list-group">
					<li class="list-group-item bg-none"><span class="fa fa-money text-success"></span> ułatwisz sobie zaplanowanie swojego budżetu</li>
					<li class="list-group-item bg-none"><span class="fa fa-money text-success"></span> w przystepnej formie graficznej zobaczysz strukturę swoich wydatków</li>
					<li class="list-group-item bg-none"><span class="fa fa-money text-success"></span> uwolnisz się od kartki i kalkulatora</li>
					<li class="list-group-item bg-none"><span class="fa fa-money text-success"></span> skrócisz czas niezbędny do archiwizowania swoich wydatków</li>
				</ul>
				
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12 align-self-center" id="userDataGroup">
			<form action="log_in.php" method="post">
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="fa fa-user input-group-text fa-22-font"></span>
					</div>
					<input class="form-control" id="name" type="text" name="login" placeholder="Login" <?=
						isset($_SESSION['set_login'])?
							 'value="'.$_SESSION['set_login'].'"' : ''
					?>></input>
				</div>
				
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text fa fa-key fa-22-font"></span>
					</div>
					<input class="form-control" id="password" type="password" name="password" placeholder="Hasło"></input>
				</div>
				
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text fa fa-envelope fa-22-font"></span>
					</div>
					<input class="form-control" id="email" type="text" name="email" placeholder="Email" <?=
						isset($_SESSION['set_email'])?
							 'value="'.$_SESSION['set_email'].'"' : ''
					?>></input>
				</div>
				
				<div class="col-sm-12 text-center text-danger mb-2" id="loginFunctionMessage"><?php
					if(isset($_SESSION['login_error'])){
						echo '<p>'.$_SESSION['login_error'].'</p>';
						unset($_SESSION['login_error']);
					}
					if(isset($_SESSION['password_error'])){
						echo '<p>'.$_SESSION['password_error'].'</p>';
						unset($_SESSION['password_error']);
					}
					if(isset($_SESSION['email_error'])){
						echo '<p>'.$_SESSION['email_error'].'</p>';
						unset($_SESSION['email_error']);
					}
					if(isset($_SESSION['successful_registration'])){
						echo '<p class="text-success light-input-bg">Twoje konto zostało założone! Zaloguj się aby je wypróbować</p>';
						unset($_SESSION['successful_registration']);
					}
				?></div>
				<input type="submit" id="signIn" class="btn btn-primary btn-block mb-2" value="Zaloguj się"></input>
			</form>
				<p class="mb-2">Nie masz jeszcze konta - zarejestruj się !</p>
				<a href="register.php" id="signUp" class="btn btn-primary btn-block mb-2">Zarejestruj się</a> 
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
	<script src="navbar_resizing.js"></script>
	<body>
	<html>