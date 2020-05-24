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
			
			$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence > '$beginningOfMonth' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
			
			$expenses_categories = $get_summary_query->fetchAll();
			
		}
		else if($timePeriod=='previousMonth'){
			$dayOfMonth = date("d");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			$d2 = strtotime($beginningOfMonth."-1 Months");
			$previousMonth = date("Y-m-d",$d2);
						
			$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence >= '$previousMonth' AND e.date_of_expence <= '$beginningOfMonth' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
			
			$expenses_categories = $get_summary_query->fetchAll();
		}
		else if($timePeriod=='lastYear'){
			$dayOfMonth = date("d");
			$month = date("m");
			$d=strtotime("- ".$dayOfMonth."Days");
			$beginningOfMonth = date("Y-m-d", $d);
			$d2 = strtotime("- ".$month."Months");
			$beginningOfYear = date("Y-m-d",$d2);
			
			$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence >= '$beginningOfYear' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
			
			$expenses_categories = $get_summary_query->fetchAll();
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
				$get_summary_query = $db->query("SELECT SUM(e.amount), ec.name_expence_cat FROM `expenses` AS e, `expenses_category_assigned_to_users` AS ec WHERE e.date_of_expence >= '$beginningOfTimePeriod' AND e.date_of_expence <= '$endingOfTimePeriod' AND e.user_id='$user_id' AND e.expence_category_assigned_to_user_id = ec.id GROUP BY e.expence_category_assigned_to_user_id");
				
				$expenses_categories = $get_summary_query->fetchAll();
				
			}
			
	}
		echo json_encode($expenses_categories);
	
?>