<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

$errorMsg = "";

session_start();

if (!isset($_SESSION['clerkId'])){
	header('Location: ClerkMainMenu.php');
	exit();
}
$clerkId = $_SESSION['clerkId'];



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (empty($_POST['toolId'])) {

		$errorMsg = "Please provide a Tool Id.";		

	}
	elseif(empty($_POST['startDate'])){
		$errorMsg = "Please provide a Start Date.";	

	}
	elseif(empty($_POST['endDate'])){
		$errorMsg = "Please provide a End Date.";		

	}
	elseif(empty($_POST['estCost'])){
		$errorMsg = "Please provide an Estimated Cost.";		

	}

	else{

		$toolId = mysql_real_escape_string($_POST['toolId']);
		$startDate = mysql_real_escape_string($_POST['startDate']);
		$endDate = mysql_real_escape_string($_POST['endDate']);
		$estCost = mysql_real_escape_string($_POST['estCost']);


		$query = "SELECT * FROM tool WHERE ToolId = '$toolId'";

		$result = mysql_query($query);

		if (mysql_num_rows($result) == 0) {

			/* tool not found */
			
			$errorMsg = "Tool not found. Please try a different Tool Id.";
			
		}
		else{
			$row = mysql_fetch_array($result);
			$sellDate = $row['SellDate'];


			if (empty($sellDate) || is_null($sellDate)){

				$reservationClash = false;
				$serviceOrderClash = false;

				$time = strtotime($startDate);
				$start = date('Y-m-d H:i:s', $time);

				$time = strtotime($endDate);
				$end = date('Y-m-d H:i:s', $time);

				/* checking for reservation clashes */
				
				$query = "SELECT ReservationId FROM reservedtool WHERE ToolId = '$toolId'";

				$result = mysql_query($query);

				while($row = mysql_fetch_array($result)){
					$reservationId = $row['ReservationId'];
					$innerquery = "SELECT StartDate, EndDate FROM reservation where ReservationId = '$reservationId'";

					$innerResult = mysql_query($innerquery);

					$innerrow = mysql_fetch_array($innerResult);

					$tmpDate = $innerrow['StartDate'];
					$resStartDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					$tmpDate =  $innerrow['EndDate'];
					$resEndDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					if ((($start >= $resStartDate) && ($start <= $resEndDate)) || (($end >= $resStartDate) && ($end <= $resEndDate))) {
						$reservationClash = true;
					}
				}


				/* checking for service order clashes */
				
				$query = "SELECT StartDate, EndDate FROM serviceorder where ToolId = '$toolId'";

				$result = mysql_query($query);

				while($row = mysql_fetch_array($result)){

					$tmpDate = $row['StartDate'];
					$serviceStartDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					$tmpDate =  $row['EndDate'];
					$serviceEndDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					if ((($start >= $serviceStartDate) && ($start <= $serviceEndDate)) || (($end >= $serviceStartDate) && ($end <= $serviceEndDate))) {
						$serviceOrderClash = true;
					}
				}


				if ($reservationClash) {
					$errorMsg = "Start Date and/or End Date provided clash(es) with an existing reservation of the tool.";

				}
				elseif ($serviceOrderClash) {
					$errorMsg = "Start Date and/or End Date provided clash(es) with another service order of the tool.";

				}
				else{
					/* ALL OK */
					$query = "INSERT INTO serviceorder (ToolId, StartDate, EndDate, EstCost, ClerkId) VALUES('$toolId', '$start', '$end', '$estCost', '$clerkId')";


					if(mysql_query($query)){
						session_start();
						$_SESSION['clerkId'] = $clerkId;
						header('Location: ClerkMainMenu.php');
					}

				}

			}
			else{
				/*  tool already sold */
				$errorMsg = "Tool is already sold.";

			}


		}


	}

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Service Order</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

					<form action="ServiceOrder.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Service Order </h1>

						<div class="serviceorder_form_row">

							<label class="toolid_label">Tool ID:</label>

							<input type="text" name="toolId" class="serviceorder_input" /> <br>

							<label class="start_label">Start Date (MM/DD/YYYY):</label>

							<input type="text" name="startDate" class="serviceorder_input" /> <br>

							<label class="end_label">End Date (MM/DD/YYYY):</label>

							<input type="text" name="endDate" class="serviceorder_input" /> <br>

							<label class="cost_label">Estmated Cost of Repair: $</label>

							<input type="text" name="estCost" class="serviceorder_input" /> <br><br><br>

						</div>						
						<input type="submit" value="Submit" /> <br>  					

					</form>

					<?php

					if (!empty($errorMsg)) {

						print "<div class='pickup_form_row' style='color:red'>$errorMsg</div>";

					}

					?>                    
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>