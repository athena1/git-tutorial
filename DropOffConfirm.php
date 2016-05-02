<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

$errorMsg = "";

$toolDetailerrorMsg = "";

$dropoffConfirmError = "";


$depositHeld = "";

$rental = "";

$estimateCost = 0.0;

$total = 0.0;

session_start();

if (!isset($_SESSION['reservationId'])){
	header('Location: DropoffMain.php');
	exit();
}

if (!isset($_SESSION['clerkId'])){
	header('Location: DropoffMain.php');
	exit();
}

$reservationId = $_SESSION['reservationId'];
$clerkId = $_SESSION['clerkId'];


// handle the two form submits


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				
	$reservationRecord = mysql_query("SELECT StartDate,EndDate,DepositHeld,RentalPrice FROM reservation where ReservationId = '$reservationId'");
	$reservation_row = mysql_fetch_array($reservationRecord);
	$depositHeld = $reservation_row['DepositHeld'];

	$rental = $reservation_row['RentalPrice'];

	$total = floatval($rental) - floatval($depositHeld);

	$query = "INSERT INTO dropoff (ReservationId, ClerkId, Total) VALUES('$reservationId', '$clerkId', '$total')";


	if(mysql_query($query)){

		session_start();

		$_SESSION['reservationId'] = $reservationId;
		$_SESSION['clerkId'] = $clerkId;


		header('Location: RentalReceipt.php');
	}
	else{
	 $dropoffConfirmError = "An unexpected error occured.";
	}
	

}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	if (empty($_GET['toolId'])) {

		$toolDetailerrorMsg = "Please provide a tool id.";

	}
	else{
		$toolid = mysql_real_escape_string($_GET['toolId']);

		$query = "SELECT * FROM tool WHERE ToolId = '$toolid'";

		$result = mysql_query($query);

		if (mysql_num_rows($result) == 1) {


			$_SESSION['toolid'] = $toolid;
			$_SESSION['reservationId'] = $reservationId;
			$_SESSION['clerkId'] = $clerkId;
			$_SESSION['type'] = 'dropoff';


			/* redirect to the profile page */
			header('Location: ViewDetail.php');

			exit();
		}

		else{
			$toolDetailerrorMsg = "Tool not found. Please try another id.";


		}
	}
}


?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Reservation Summary</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="reservationDetails">
				<?php

				
				$reservationRecord = mysql_query("SELECT StartDate,EndDate,DepositHeld,RentalPrice FROM reservation where ReservationId = '$reservationId'");
				$reservation_row = mysql_fetch_array($reservationRecord);

				$start_date = new DateTime($reservation_row['StartDate']);
				$end_date = new DateTime($reservation_row['EndDate']);

				$numDays = $start_date->diff($end_date)->days;

				$depositHeld = $reservation_row['DepositHeld'];

				$rental = $reservation_row['RentalPrice'];

				$estimateCost = floatval($depositHeld) + floatval($rental);


				?>
				<label class="reservationNo"><b>Reservation Number: </b></label> <?php print $reservationId ?> <br><br>

				<label class="toolsList"><b>Tools Required: </b></label> <br><br>

				<?php 

				$query = "SELECT R.ToolId,T.AbbrDesc FROM reservedtool AS R INNER JOIN tool AS T ON R.ToolId = T.ToolId WHERE R.ReservationId = '$reservationId'";

				$result = mysql_query($query);


				if (mysql_num_rows($result) == 0) {

					$errorMsg="No tools are reserved in this reservation. Please try another reservation Id.";
				}

				if (!empty($errorMsg)) {

					print "<div class='reservationDetails' style='color:red'>$errorMsg</div>";

				}
				$i = 0;
				while($row = mysql_fetch_array($result)){
					$i++;
					$id = $row['ToolId'];
					$description = $row['AbbrDesc'];
					print "<label class='tool$i'>$i. $id: $description </label> <br><br>";

				}

				?>


				<label class="deposit"><b>Deposit Required: </b>$</label> <?php print $depositHeld ?><br><br>

				<label class="totalcost"><b>Estimated Cost: </b>$</label> <?php print $estimateCost ?><br><br>


				


			</div>

			<hr> <br>

			<form action="DropoffConfirm.php" method="get">
				<label class="toolId_label">Tool Id: </label>

				<input type="text" name="toolId" class="viewDetail_input" />

				<input type="submit" value="View Details" /> <br> <br> 		

				<?php

				if (!empty($toolDetailerrorMsg)) {

					print "<div class='dropoff_confirm_row' style='color:red'>$toolDetailerrorMsg</div>";

				}

				?>     			


			</form>

			<hr><br>

			
			<form action="DropoffConfirm.php" method="post">			
					

				<input type="submit" value="Complete DropOff" /> <br>  
				<?php

				if (!empty($paymentErrrorMsg)) {

					print "<div class='pickup_confirm_row' style='color:red'>$query</div>";

				}
				
				?>  


			</form>

		</div>
	</body>

</html>