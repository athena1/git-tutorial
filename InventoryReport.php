<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

// get from somewhere
$clerkId = "";

session_start();
if (!isset($_SESSION['clerkId'])){
	header('Location: GenerateReports.php');
	exit();
}


$clerkId = $_SESSION['clerkId'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();

	$_SESSION['clerkId'] = $clerkId;

	header('Location: ClerkMainMenu.php');

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Inventory Report</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

					<form action="InventoryReport.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Inventory Report </h1>

						<div class="invreport_form_row">
							<table border="1" style="width:100%">
							  <tr>
							    <td><b>Tool Id</b></td>
							    <td><b>Rental Profit</b></td>		
							    <td><b>Cost of Tool</b></td>
							    <td><b>Total Profit</b></td>
							  </tr>
							  <?php
							  $toolId = "";
							  $rentPerDay = 0.0;
							  $totalProfit = 0.0;

							  $query = "SELECT ToolId, Rental, Purchase FROM tool WHERE SellDate IS NULL";

							  $result = mysql_query($query);

							  while($row = mysql_fetch_array($result)){
							  	$toolId = $row['ToolId'];
							  	$rentPerDay= floatval($row['Rental']);

							  	$reservedtoolquery = "SELECT ReservationId from reservedtool WHERE ToolId = '$toolId'";
								$reservedtoolresult = mysql_query($reservedtoolquery);

								$rentalProfit = 0.0;

								/* iterating through all reservations for tool */
								while($reservedtoolrow = mysql_fetch_array($reservedtoolresult)){
									$reservationId = $reservedtoolrow['ReservationId'];
							  		$reservationquery = "SELECT StartDate, EndDate from reservation WHERE ReservationId = '$reservationId'";

							  		$reservationresult = mysql_query($reservationquery);

									if (mysql_num_rows($reservationresult) == 1) {

										$reservationrow = mysql_fetch_array($reservationresult);

										$start = new DateTime($reservationrow['StartDate']);
										$end = new DateTime($reservationrow['EndDate']);

										$numDays = $start->diff($end)->days;

										$rentalProfit = $rentalProfit + ($rentPerDay * $numDays);


									}

								}

								/** initialize the tool cost first with the purchase price of tool */
								$toolCost = floatval($row['Purchase']);;

								$serviceorderquery = "SELECT EstCost from serviceorder WHERE ToolId = '$toolId'";
								$serviceorderresult = mysql_query($serviceorderquery);

								while($serviceorderrow = mysql_fetch_array($serviceorderresult)){
									$toolCost = $toolCost + floatval($serviceorderrow['EstCost']);
								}



								$totalProfit = $rentalProfit - $toolCost;
								
							  	print "<tr><td>$toolId</td><td>$rentalProfit</td><td>$toolCost</td><td>$totalProfit</td></tr>";

							  }

							  ?>

							</table>
			

						</div>						
						<input type="submit" value="Back To Main Menu" /> <br>  					

					</form>                  
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>