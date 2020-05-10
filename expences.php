<?php
	session_start();
	if(isset($_SESSION['logged_User_Id'])==false){
		header('Location:index.php');
		exit();
	}
	
	echo $_POST['expenceAmount'];
	echo $_POST['expenceCat'];
	echo $_POST['commentExpence'];
	echo $_POST['payment'];
	echo $_POST['dateExpence'];
	unset($_POST['expenceCat']);
	unset($_POST['expenceAmount']);
	unset($_POST['commentExpence']);
	unset($_POST['payment']);
	unset($_POST['dateExpence']);
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
				<div class="row justify-content-center" id="expenceContainer">
						<div class="col-sm-6 mt-2">
							<div class="row">
								<form method="post" class="input-group col-sm-12">
								<div class="col-sm-12 mb-2 text-center">
									<h4>Dodawanie nowego wydatku</h4>
								</div>
							
								<div class="col-sm-12 mb-2">
									<p>Kwota wydatku: </p>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Podaj kwotę wydatku" name="expenceAmount">
										<div class="input-group-append">
											<span class="input-group-text"> PLN </span>
										</div>
									</div>
								</div>
								<div class="col-sm-12 mb-2">
									<div class="form-group">
										<p>Data wydatku:</p>
										<input type="date" class="form-control" name="dateExpence">
									</div>
								</div>
								<div class="col-sm-12 mb-2 border border-success">
									<div id="expencePaymentWay" class="form-group">
										<p>Sposób płatności:</p>
										<div class="custom-control custom-radio" id="Gotówka">
											<input type="radio" class="custom-control-input" id="money" value="Gotówka" name="payment">
											<label class="custom-control-label" for="money"> Gotówka </label>
										</div>
										<div class="custom-control custom-radio" id="KartaDebetowa">
											<input type="radio" class="custom-control-input" id="debetCard" value="KartaDebetowa" name="payment">
											<label class="custom-control-label" for="debetCard"> Karta Debetowa </label>
										</div>
										<div class="custom-control custom-radio" id="KartaKredytowa">
											<input type="radio" class="custom-control-input" id="creditCard" value="KartaKredytowa" name="payment">
											<label class="custom-control-label" for="creditCard"> Karta Kredytowa </label>
										</div>
									</div>
								</div>
								<div class="col-sm-12 mb-2 py-2 border border-success">
									<div id="expenceCategory" class="form-group">
										<p>Kategoria wydatku:</p>
										
										<div class="custom-control custom-radio" id="Jedzenie">
											<input type="radio" class="custom-control-input" name="expenceCat" id="eating" value="Jedzenie">
											<label class="custom-control-label" for="eating">Jedzenie</label>
										</div>
										<div class="custom-control custom-radio" id="Mieszkanie">
											<input type="radio" class="custom-control-input" name="expenceCat" id="roomPayment" value="Mieszkanie">
											<label class="custom-control-label" for="roomPayment">Mieszkanie</label>
										</div>
										<div class="custom-control custom-radio" id="Transport">
											<input type="radio" class="custom-control-input" name="expenceCat" id="vehicles" value="Transport">
											<label class="custom-control-label" for="vehicles">Transport</label>
										</div>
										<div class="custom-control custom-radio" id="Telekomunikacja">
											<input type="radio" class="custom-control-input" name="expenceCat" id="communicationMedia" value="Telekomunikacja">
											<label class="custom-control-label" for="communicationMedia">Telekomunikacja</label>
										</div>
										<div class="custom-control custom-radio" id="Opiekazdrowotna">
											<input type="radio" class="custom-control-input" name="expenceCat" id="healthCare" value="Opieka zdrowotna">
											<label class="custom-control-label" for="healthCare">Opieka zdrowotna</label>
										</div>
										<div class="custom-control custom-radio" id="Ubranie">
											<input type="radio" class="custom-control-input" name="expenceCat" id="clothing" value="Ubranie">
											<label class="custom-control-label" for="clothing">Ubranie</label>
										</div>
										<div class="custom-control custom-radio" id="Higiena">
											<input type="radio" class="custom-control-input" name="expenceCat" id="hygene" value="Higiena">
											<label class="custom-control-label" for="hygene">Higiena</label>
										</div>
										<div class="custom-control custom-radio" id="Dzieci">
											<input type="radio" class="custom-control-input" name="expenceCat" id="children" value="Dzieci">
											<label class="custom-control-label" for="children">Dzieci</label>
										</div>
										<div class="custom-control custom-radio" id="Rozrywka">
											<input type="radio" class="custom-control-input" name="expenceCat" id="entertainment" value="Rozrywka">
											<label class="custom-control-label" for="entertainment">Rozrywka</label>
										</div>
										<div class="custom-control custom-radio" id="Wycieczka">
											<input type="radio" class="custom-control-input" name="expenceCat" id="journey" value="Wycieczka">
											<label class="custom-control-label" for="journey">Wycieczka</label>
										</div>
										<div class="custom-control custom-radio" id="Szkolenia">
											<input type="radio" class="custom-control-input" name="expenceCat" id="instructions" value="Szkolenia">
											<label class="custom-control-label" for="instructions">Szkolenia</label>
										</div>
										<div class="custom-control custom-radio" id="Książki">
											<input type="radio" class="custom-control-input" name="expenceCat" id="books" value="Książki">
											<label class="custom-control-label" for="books">Książki</label>
										</div>
										<div class="custom-control custom-radio" id="Oszczędności">
											<input type="radio" class="custom-control-input" name="expenceCat" id="savings" value="Oszczędności">
											<label class="custom-control-label" for="savings">Oszczędności</label>
										</div>
										<div class="custom-control custom-radio" id="Darowizna">
											<input type="radio" class="custom-control-input" name="expenceCat" id="donation" value="Darowizna">
											<label class="custom-control-label" for="donation">Darowizna</label>
										</div>
										<div class="custom-control custom-radio" id="Spłatadługów">
											<input type="radio" class="custom-control-input" name="expenceCat" id="debtsPayment" value="Spłata długów">
											<label class="custom-control-label" for="debtsPayment">Spłata długów</label>
										</div>
										<div class="custom-control custom-radio" id="Nazłotąjesieńczyliemeryturę">
											<input type="radio" class="custom-control-input" name="expenceCat" id="retirement" value="Na złotą jesień, czyli emeryturę">
											<label class="custom-control-label" for="retirement">Na złotą jesień, czyli emeryturę</label>
										</div>
										<div class="custom-control custom-radio" id="Innewydatki">
											<input type="radio" class="custom-control-input" name="expenceCat" id="otherExpences" value="Inne wydatki">
											<label class="custom-control-label" for="otherExpences">Inne wydatki</label>
										</div>
									</div>
								</div>
								<div class="col-sm-12 mb-2">
									<div class="form-group">
										<p>Komentarz(opcjonalnie):</p>
										<textarea class="form-control" placeholder="" name="commentExpence"></textarea>
									</div>
								</div>
							
								<div id="addExpenceFunctionMessage" class="text-danger col-sm-12 text-center mb-2"></div>
								<div class="col-sm-12 mb-2">
									<button type="submit" class="btn btn-success btn-block" id="addExpenceButton"><span class="fa fa-save"></span> Dodaj nowy wydatek</button>
								</div>
								</form>
							</div>
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