<?php
	session_start();
	if(!isset($_SESSION['logged_User_Id'])){
		header('Location:index.php');
		exit();
	}
	
	if(isset($_POST['incomeAmount'])){
		$incomeAmount = preg_replace("/[^0-9.,]/", "", $_POST['incomeAmount']);
		if($incomeAmount!=$_POST['incomeAmount']){
			$_SESSION['added_income_message'] = 'Kwota dochodu powinna zawierać jedynie cyfry i znak "."';
			//exit();
		}

		//$_SESSION['added_income_message'] = '<p class="text-success">submitted by button'.$_POST['incomeAmount'].'||'.$_POST['dateIncome'].'||'.$_POST['incomeCategory'].'||'.$_POST['commentIncome'].'||'.$incomeAmount.'</p>';
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
		
		<div class="row py-2 px-2 custom-bg" id="content">
			<div class="col-sm-12">
				
					<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
						<a class="navbar-brand" id="home" href="main.php"><span class="fa fa-home"> Główna</span></a>
						<button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#siteNavbar">
							<span class="navbar-toggler-icon"></span>
						</button>
					
						<div class="collapse navbar-collapse" id="siteNavbar">
						  <ul class="navbar-nav mr-auto w-100" id="navList">
							<li class="nav-item w-20" id="incomes"><a class="nav-link" href="incomes.php">Nowy dochód <span class="fa fa-plus-circle"></span></a></li>
							<li class="nav-item w-20" id="expences"><a class="nav-link" href="expences.php">Nowy wydatek <span class="fa fa-minus-circle"></span></a></li>
							<li class="nav-item w-20" id="summary"><a class="nav-link" href="summary.php">Bilans <span class="fa fa-line-chart"></span></a></li>
							<li class="nav-item w-20" id="setup"><a class="nav-link" href="setup.php">Ustawienia <span class="fa fa-wrench"></span></a></li>
							<li class="nav-item w-20" id="log-out"><a class="nav-link" href="logout.php">Wyloguj <span class="fa fa-sign-out"></span></a></li>
						  </ul>
						</div>
					</nav>
				
			</div>
			<div class="col-sm-12">		
				
				<div class="row justify-content-center" id="incomesContainer">
					<div class="col-sm-6 mt-2">
					<form method="post">
						<div class="row">
							<div class="col-sm-12 mb-2 text-center">
								<h4>Dodawanie nowego dochodu</h4>
							</div>
							<div class="col-sm-12 mb-2">
								<p>Kwota dochodu: </p>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Podaj kwotę dochodu" name="incomeAmount">
									<div class="input-group-append">
										<span class="input-group-text"> PLN </span>
									</div>
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<p>Data dochodu:</p>
									<input type="date" id="dateIncome" class="form-control" name="dateIncome">
								</div>
							</div>
							<div class="col-sm-12 mb-2 border border-success">
								<div id="incomeCategory" class="form-group">
									<p>Kategoria:</p>
									<div id="Wynagrodzenie" class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="salary" value="Wynagrodzenie" name="incomeCategory" checked>  
										<label class="custom-control-label" for="salary"> Wynagrodzenie</label>
									</div>
									<div id="Odsetkibankowe" class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="intrests" value="Odsetki bankowe" name="incomeCategory">
										<label class="custom-control-label" for="intrests"> Odsetki bankowe</label>
									</div>
									<div id="SprzedażnaAllegro" class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="allegroSell" value="Sprzedaż na Allegro" name="incomeCategory">
										<label class="custom-control-label" for="allegroSell">Sprzedaż na Allegro </label>
									</div>
									<div id="Inneźródło" class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="otherIncomeCat" value="Inne źródło" name="incomeCategory">
										<label class="custom-control-label" for="otherIncomeCat"> Inne źródło </label>
									</div>
									
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<p>Komentarz(opcjonalnie):</p>
									<textarea id="commentIncome" class="form-control" placeholder="" name="commentIncome"></textarea>
								</div>
							</div>
							<div id="addIncomeFunctionMessage" class="text-danger col-sm-12 text-center mb-2">
								<?php
									if(isset($_SESSION['added_income_message'])){
										echo $_SESSION['added_income_message'];
										unset($_SESSION['added_income_message']);
									}
								?>
							</div>
							<div class="col-sm-12 mb-2">
								<button type="submit" class="btn btn-success btn-block" id="addIncomeButton"> <span class="fa fa-save"></span> Dodaj nowy dochód</input>
							</div>
						</div>
					</form>
						
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!--Bootstrap-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="budzet.js"></script> 
	
</body>
</html>