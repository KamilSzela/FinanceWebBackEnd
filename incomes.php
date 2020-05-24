<?php
	session_start();
	if(isset($_SESSION['logged_User_Id'])==false){
		header('Location:index.php');
		exit();
	}
	else{
		require_once 'database.php';
		$user_id = $_SESSION['logged_User_Id'];
		$get_cathegories_Query = $db->prepare('SELECT id,name FROM incomes_category_assigned_to_users WHERE user_id = :id');
		$get_cathegories_Query->bindValue(':id', $user_id, PDO::PARAM_INT);
		$get_cathegories_Query->execute();
	
		$users_cathegories = $get_cathegories_Query->fetchAll();		
	}
	
	$invalidData = false;

	if(isset($_POST['incomeAmount'])){
		$incomeAmount = preg_replace("/[^0-9.,]/", "", $_POST['incomeAmount']);
		
		if($incomeAmount!=$_POST['incomeAmount']||$incomeAmount==""){
			$_SESSION['added_income_message'] = 'Kwota dochodu powinna zawierać jedynie cyfry i znak "." lub ","';
			$invalidData = true;
		}
		
		if($invalidData==false){
			$incomeAmountCommaReplacement = str_replace(',','.',$incomeAmount);
			$incomeFloatFormat = floatval($incomeAmountCommaReplacement);
			//$checktype = is_float($incomeDoubleFormat);
			//$_SESSION['added_income_message'] = 'czy float:'.$checktype.', wartość:'.$incomeDoubleFormat;
		}	
		$_SESSION['loaded_amount']=$_POST['incomeAmount'];
		if($invalidData==false){
			$dateValue = preg_replace("/[^0-9\-]/","",$_POST['dateIncome']);
			if($dateValue!=$_POST['dateIncome']||$dateValue==""){
				$invalidData = true;
				$_SESSION['added_income_message'] = 'Proszę wpisać datę w formacie rrrr-mm-dd';
			}
		}
		$_SESSION['loaded_date']=$_POST['dateIncome'];
		if(!isset($_POST['incomeCategory'])){
			$invalidData = true;
			$_SESSION['added_income_message'] = 'Proszę wybrać kategorię wydatku';
		}
		$_SESSION['loaded_comment']=$_POST['commentIncome'];
		if($invalidData==false){
				$userId = $_SESSION['logged_User_Id'];
				$cathegory_assigned_to_user = $_POST['incomeCategory'];
			if(isset($_POST['commentIncome'])&&$_POST['commentIncome']!=""){
				$comment = filter_input(INPUT_POST, 'commentIncome', FILTER_SANITIZE_SPECIAL_CHARS);
				$insert_income_query = $db->exec("INSERT INTO incomes VALUES(NULL, '$userId', '$cathegory_assigned_to_user', '$incomeFloatFormat','$dateValue','$comment')");
				$_SESSION['added_income_message'] = '<p class="text-success">Dodano nowy dochód do Twojej bazy danych!</p>';
			}
			else{
				$insert_income_query = $db->exec("INSERT INTO incomes VALUES(NULL, '$userId', '$cathegory_assigned_to_user', '$incomeFloatFormat','$dateValue',\"\")");
				$_SESSION['added_income_message'] = '<p class="text-success">Dodano nowy dochód do Twojej bazy danych!</p>';
			}
			unset($_SESSION['loaded_amount']);
			unset($_SESSION['loaded_date']);
			unset($_SESSION['loaded_comment']);
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
									<input type="text" class="form-control" placeholder="Podaj kwotę dochodu" name="incomeAmount" <?=
											isset($_SESSION['loaded_amount'])?
											'value="'.$_SESSION['loaded_amount'].'"' : ''
									?>>
									<div class="input-group-append">
										<span class="input-group-text"> PLN </span>
									</div>
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<p>Data dochodu:</p>
									<input type="date" id="dateIncome" class="form-control" name="dateIncome" <?=
											isset($_SESSION['loaded_date'])?
											'value="'.$_SESSION['loaded_date'].'"' : ''
									?>>
								</div>
							</div>
							<div class="col-sm-12 mb-2 border border-success">
								<div id="incomeCategory" class="form-group">
									<p>Kategoria:</p>							
									<?php
										foreach($users_cathegories as $cathegorie){
											echo '<div class="custom-control custom-radio light-input-bg">';
											echo '<input type="radio" class="custom-control-input" id="'.$cathegorie['name'] .'" value="'.$cathegorie['id'].'" name="incomeCategory">';
											echo '<label class="custom-control-label" for="'.$cathegorie['name'].'">'.$cathegorie['name'].'</label>';
											echo '</div>';
										}										
									?>	
								</div>
							</div>
							<div class="col-sm-12 mb-2">
								<div class="form-group">
									<p>Komentarz(opcjonalnie):</p>
									<textarea id="commentIncome" class="form-control" placeholder="" name="commentIncome"> <?=
											isset($_SESSION['loaded_comment'])?
											$_SESSION['loaded_comment'] : ''
									?></textarea>
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
	<script src="navbar_resizing.js"></script>
	
</body>
</html>