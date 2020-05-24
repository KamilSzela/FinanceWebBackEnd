<?php
	session_start();
	if(!isset($_SESSION['logged_User_Id'])){
		header('Location:index.php');
		exit();
	}
	require_once ('database.php');
	$user_id = $_SESSION['logged_User_Id'];
	if(isset($_GET['timePeriod'])){
		$timePeriod = $_GET['timePeriod'];
		if($timePeriod=='lastMonth'){
			$dayOfMonth = date("d");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			
			$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income > '$beginningOfMonth' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
			$incomes_categories = $get_incomes_summary_query->fetchAll();
			
		}
		else if($timePeriod=='previousMonth'){
			$dayOfMonth = date("d");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			$d2 = strtotime($beginningOfMonth."-1 Months");
			$previousMonth = date("Y-m-d",$d2);
						
			$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$previousMonth' AND i.date_of_income <= '$beginningOfMonth' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
			$incomes_categories = $get_incomes_summary_query->fetchAll();
		}
		else if($timePeriod=='lastYear'){
			$dayOfMonth = date("d");
			$month = date("m");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			$d2 = strtotime("- ".$month."Months");
			$beginningOfYear = date("Y-m-d",$d2);
			
			$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$beginningOfYear' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
			$incomes_categories = $get_incomes_summary_query->fetchAll();
		}
		
	}else if(isset($_GET['beginDate'])){
			$beginningOfTimePeriod = filter_input(INPUT_GET, 'beginDate');
			$endingOfTimePeriod = filter_input(INPUT_GET, 'endDate');
			$d1=strtotime($beginningOfTimePeriod);
			$d2=strtotime($endingOfTimePeriod);
			$diff=$d2-$d1;
			
			if($diff<0){
				$_SESSION['dateMessage'] = '<p class="text-danger">Data końca okresu nie moze być mniejsza niż data początku okresu!</p>';
			}
			else{
				$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income >= '$beginningOfTimePeriod' AND i.date_of_income <= '$endingOfTimePeriod' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
				$incomes_categories = $get_incomes_summary_query->fetchAll();
				
			}	
	}
	else{
		$dayOfMonth = date("d");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			
			$get_incomes_summary_query = $db->query("SELECT SUM(i.amount), ic.name FROM `incomes` AS i, `incomes_category_assigned_to_users` AS ic WHERE i.date_of_income > '$beginningOfMonth' AND i.user_id='$user_id' AND i.income_category_assigned_to_user_id = ic.id GROUP BY i.income_category_assigned_to_user_id");
			
			$incomes_categories = $get_incomes_summary_query->fetchAll();
	}
	
		echo json_encode($incomes_categories);
	
?>