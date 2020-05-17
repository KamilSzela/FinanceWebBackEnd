<?php
	session_start();
	if(!isset($_SESSION['logged_User_Id'])){
		header('Location:index.php');
		exit();
	}
	if(isset($_POST['dateSpan'])){
		$timePeriod = $_POST['dateSpan'];
		require_once 'database.php';
		$user_id = $_SESSION['logged_User_Id'];
		
		if($timePeriod=='lastMonth'){
			$dayOfMonth = date("d");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			
			$get_expences_query = $db->query("SELECT e.amount, e.date_of_expence, ec.name_expence_cat, pm.name, e.expence_comment FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec, `payment_methods_assigned_to_users` AS pm WHERE e.date_of_expence > '$beginningOfMonth' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id AND e.payment_method_assigned_to_user_id = pm.id ORDER BY e.expence_category_assigned_to_user_id");
			 
			$users_Expenses = $get_expences_query->fetchAll();
			
			$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence > '$beginningOfMonth' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
			
			$expenses_categories = $get_summary_query->fetchAll();
			
			
			$get_incomes_query = $db->query("SELECT i.amount, i.date_of_income, ic.name, i.income_comment FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income > '$beginningOfMonth' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id ORDER BY i.income_category_assigned_to_user_id");
			 
			$users_Incomes = $get_incomes_query->fetchAll();
			
			$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income > '$beginningOfMonth' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
			$incomes_categories = $get_incomes_summary_query->fetchAll();
		}
		if($timePeriod=='previousMonth'){
			$dayOfMonth = date("d");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			$d2 = strtotime($beginningOfMonth."-1 Months");
			$previousMonth = date("Y-m-d",$d2);
						
			$get_expences_query = $db->query("SELECT e.amount, e.date_of_expence, ec.name_expence_cat, pm.name, e.expence_comment FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec, `payment_methods_assigned_to_users` AS pm WHERE e.date_of_expence >= '$previousMonth' AND e.date_of_expence <= '$beginningOfMonth' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id AND e.payment_method_assigned_to_user_id = pm.id ORDER BY e.expence_category_assigned_to_user_id");
			
			$users_Expenses = $get_expences_query->fetchAll();
			
			$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence >= '$previousMonth' AND e.date_of_expence <= '$beginningOfMonth' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
			
			$expenses_categories = $get_summary_query->fetchAll();
			
			$get_incomes_query = $db->query("SELECT i.amount, i.date_of_income, ic.name, i.income_comment FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$previousMonth' AND i.date_of_income <= '$beginningOfMonth' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id ORDER BY i.income_category_assigned_to_user_id");
			 
			$users_Incomes = $get_incomes_query->fetchAll();
			
			$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$previousMonth' AND i.date_of_income <= '$beginningOfMonth' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
			$incomes_categories = $get_incomes_summary_query->fetchAll();
		}
		if($timePeriod=='lastYear'){
			$dayOfMonth = date("d");
			$month = date("m");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			$d2 = strtotime("- ".$month."Months");
			$beginningOfYear = date("Y-m-d",$d2);
			
			$get_expences_query = $db->query("SELECT e.amount, e.date_of_expence, ec.name_expence_cat, pm.name, e.expence_comment FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec, `payment_methods_assigned_to_users` AS pm WHERE e.date_of_expence >= '$beginningOfYear' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id AND e.payment_method_assigned_to_user_id = pm.id ORDER BY e.expence_category_assigned_to_user_id");
			
			$users_Expenses = $get_expences_query->fetchAll();
			
			$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence >= '$beginningOfYear' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
			
			$expenses_categories = $get_summary_query->fetchAll();
		
			$get_incomes_query = $db->query("SELECT i.amount, i.date_of_income, ic.name, i.income_comment FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$beginningOfYear' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id ORDER BY i.income_category_assigned_to_user_id");
			 
			$users_Incomes = $get_incomes_query->fetchAll();
			
			$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$beginningOfYear' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
			$incomes_categories = $get_incomes_summary_query->fetchAll();
		}
		if($timePeriod=='nonStandardSpan'){
			
			$beginningOfTimePeriod = filter_input(INPUT_POST, 'beginnigTimeSpan');
			$endingOfTimePeriod = filter_input(INPUT_POST, 'endingTimeSpan');
			$d1=strtotime($beginningOfTimePeriod);
			$d2=strtotime($endingOfTimePeriod);
			$diff=$d2-$d1;
			
			if($diff<0){
				$_SESSION['dateMessage'] = '<p class="text-danger">Data końca okresu nie moze być mniejsza niż data początku okresu!</p>';
			}
			else{
				$get_expences_query = $db->query("SELECT e.amount, e.date_of_expence, ec.name_expence_cat, pm.name, e.expence_comment FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec, `payment_methods_assigned_to_users` AS pm WHERE e.date_of_expence >= '$beginningOfTimePeriod' AND e.date_of_expence <= '$endingOfTimePeriod' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id AND e.payment_method_assigned_to_user_id = pm.id ORDER BY e.expence_category_assigned_to_user_id");
				
				$users_Expenses = $get_expences_query->fetchAll();
				
				$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence >= '$beginningOfTimePeriod' AND e.date_of_expence <= '$endingOfTimePeriod' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
				
				$expenses_categories = $get_summary_query->fetchAll();
				
				$get_incomes_query = $db->query("SELECT i.amount, i.date_of_income, ic.name, i.income_comment FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$beginningOfTimePeriod' AND i.date_of_income <= '$endingOfTimePeriod' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id ORDER BY i.income_category_assigned_to_user_id");
			 
				$users_Incomes = $get_incomes_query->fetchAll();
			
				$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$beginningOfTimePeriod' AND i.date_of_income <= '$endingOfTimePeriod' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
				$incomes_categories = $get_incomes_summary_query->fetchAll();
			}
		}
		if(count($users_Expenses)==0){
				$_SESSION['no_Expences']="<tbody><tr><td class=\"text-center\">Brak wydatków w rozpatrywanym okresie</td></tr></tbody>";
			}
		if(count($users_Incomes)==0){
				$_SESSION['no_Incomes']="<tbody><tr><td class=\"text-center\">Brak dochodów w rozpatrywanym okresie</td></tr></tbody>";
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
				<div class="row" id="summaryContainer">
					<div class="col-sm-12" id="divToHeightEvaluation">
						<div class="row justify-content-center">
							<div class="col-md-6 col-sm-12">
								<div class="row">
									<form method="post">
									<div class="col-sm-12 my-2">
										<h4 class="text-center"><b>Podsumowanie wydatków oraz dochodów za podany okres</b></h4>
									</div>
									
									<div class="col-sm-12 mb-2">
										<div id="choosePeriodDiv" class="input-group">
											<select class="custom-select" name="dateSpan" id="chosenDateSpan">
												<option value="lastMonth" selected>Obecny miesiąc</option>
												<option value="previousMonth" >Poprzedni miesiąc</option>
												<option value="lastYear" >Obecny rok</option>
												<option value="nonStandardSpan" >Wybierz niestandardowy okres</option>
											</select>
										</div>
									</div>
									<div id="nonStandardDateInput" class="d-none col-sm-12 mb-2 justify-content-center">
										<div class="row">
											<div class="col-sm-12">
												<label for="beginDateInput">Data początkowa</label>
												<input type="date" id="beginDateInput" name="beginnigTimeSpan" class="form-control">
											</div>
											<div class="col-sm-12">
												<label for="endingDateInput">Data końcowa</label>
												<input type="date" id="endingDateInput" name="endingTimeSpan" class="form-control">
											</div>
											
										</div>	
									</div>
									<div class="col-sm-12 text-danger text-center" id="dateMessageDiv">
											<?php
												if(isset($_SESSION['dateMessage'])){
													echo $_SESSION['dateMessage'];
													unset($_SESSION['dateMessage']);
												}
											?>
											</div>
									<div class="col-sm-12 mb-2">
										<button type="submit" class="btn btn-success btn-block" id="generateSummaryButton">Generuj tabele</button>
									</div>
									</form>
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-12">
										<h4 class="mb-3 text-center" id="expenceTableHeader"><?php
										if(isset($users_Expenses) && count($users_Expenses)!=0){
											echo '<b>Tabela twoich wydatków:</b>';
										}
										?></h4>
										<table id="expenceTable" class="table table-sm table-dark table-striped table-hover">
										<?php
											if(isset($users_Expenses) && count($users_Expenses)!=0){
												
												echo '<thead><tr><th class="text-center">Kwota</th><th class="text-center">Data</th><th class="text-center">Kategoria</th><th class="text-center">Sposób płatności</th><th class="text-center">Komentarz</th></tr></thead>';
												echo '<tbody>';
												foreach($users_Expenses as $expence){
													echo '<tr><td class="text-center">'.$expence[0].'</td><td class="text-center">'.$expence[1].'</td><td class="text-center">'.$expence[2].'</td><td class="text-center">'.$expence[3].'</td><td class="text-center">'.$expence[4].'</td></tr>';	
												}
												echo '</tbody>';
											}
											else{
												if(isset($_SESSION['no_Incomes'])){
													echo $_SESSION['no_Expences'];
													unset($_SESSION['no_Expences']);
												}
											}
										?>
										</table>
										<h4 class="mb-3 text-center" id="expenceCategoriesTableHeader"><?php
										if(isset($users_Expenses) && count($users_Expenses)!=0){
											echo '<b>Tabela podsumowująca twoje wydatki względem kategorii:</b>';
										}
										?></h4>
										<table id="expenceCategoriesTable" class="table table-sm table-dark table-striped table-hover">
										<?php
											if(isset($expenses_categories) && count($expenses_categories)!=0){
												
												echo '<thead><tr><th class="text-center">Wartość w kategorii</th><th class="text-center">Kategoria</th></thead>';
												echo '<tbody>';
												foreach($expenses_categories as $category){
													echo '<tr><td class="text-center">'.$category[0].'</td><td class="text-center">'.$category[1].'</td></tr>';	
												}
												echo '</tbody>';
											}
										?>
										</table>
									</div>
									<div class="col-sm-12">
									<h4 class="mb-3 text-center" id="incomeTableHeader"><?php
										if(isset($users_Incomes) && count($users_Incomes)!=0){
											echo '<b>Tabela twoich dochodów:</b>';
										}
										?></h4>
										<table id="incomeTable" class="table table-sm table-dark table-striped table-hover">
										<?php
											if(isset($users_Incomes) && count($users_Incomes)!=0){
												
												echo '<thead><tr><th class="text-center">Kwota</th><th class="text-center">Data</th><th class="text-center">Kategoria</th><th class="text-center">Komentarz</th></tr></thead>';
												echo '<tbody>';
												foreach($users_Incomes as $income){
													echo '<tr><td class="text-center">'.$income[0].'</td><td class="text-center">'.$income[1].'</td><td class="text-center">'.$income[2].'</td><td class="text-center">'.$income[3].'</td></tr>';	
												}
												echo '</tbody>';
											}
											else{
												if(isset($_SESSION['no_Incomes'])){
													echo $_SESSION['no_Incomes'];
													unset($_SESSION['no_Incomes']);
												}
											}
										?>
										</table>
										<h4 class="mb-3 text-center" id="incomeCategoriesTableHeader"><?php
										if(isset($users_Incomes) && count($users_Incomes)!=0){
											echo '<b>Tabela podsumowująca twoje dochody względem kategorii:</b>';
										}
										?></h4>
										<table id="incomeCategoriesTable" class="table table-sm table-dark table-striped table-hover">
										<?php
											if(isset($incomes_categories) && count($incomes_categories)!=0){
												
												echo '<thead><tr><th class="text-center">Wartość w kategorii</th><th class="text-center">Kategoria</th></thead>';
												echo '<tbody>';
												foreach($incomes_categories as $category){
													echo '<tr><td class="text-center">'.$category[0].'</td><td class="text-center">'.$category[1].'</td></tr>';	
												}
												echo '</tbody>';
											}
										?>
										</table>
									</div>
									<div class="col-sm-12 text-center mb-2 pt-2" id="showEvaluation">
									
									</div>
									<div class="col-sm-12">
										<div id="chartExpencesContainer"></div>
									</div>
								</div>
							</div>
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
	<script src="money.js"></script> 
	
</body>
</html>