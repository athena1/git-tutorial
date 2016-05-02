<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

$errorMsg = "";

$clerkName = "";
$customerName = "";
$creditCard = "";
$startDate = "";
$endDate = "";
$deposit = "";
$estimatedRental = "";
$total = 0;

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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	$_SESSION['clerkId'] = $clerkId;
	header('Location: ClerkMainMenu.php');

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Receipt</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="rentalReceipt">
				<?php

				$query= "SELECT FirstName,LastName FROM users WHERE UserId = '$clerkId'";
				$result = mysql_query($query);
				$row = mysql_fetch_array($result);

				$clerkName = $row['FirstName'] . $row['LastName'];

				$query = "SELECT * FROM reservation WHERE ReservationId = '$reservationId'";
				$result = mysql_query($query);
				$reservation_record = mysql_fetch_array($result);

				$customerId = $reservation_record['CustomerId'];

				$query= "SELECT FirstName,LastName FROM users WHERE UserId = '$customerId'";
				$result = mysql_query($query);
				$row = mysql_fetch_array($result);

				$customerName = $row['FirstName'] . $row['LastName'];

				$query= "SELECT CreditCard FROM pickup WHERE ReservationId = '$reservationId' AND ClerkId = '$clerkId'";
				$result = mysql_query($query);
				$row = mysql_fetch_array($result);

				$creditCard = $row['CreditCard'];

				$startDateTime = $reservation_record['StartDate'];
				$endDateTime = $reservation_record['EndDate'];

				$tmp = date_create($startDateTime);
				$startDate = date_format($tmp, 'm-d-Y');
				$tmp = date_create($endDateTime);
				$endDate = date_format($tmp, 'm-d-Y');

				$depositHeld = $reservation_record['DepositHeld'];
				$estimatedRental = $reservation_record['RentalPrice'];

				$total = floatval($estimatedRental) - floatval($depositHeld);

				?>

				<form action="RentalReceipt.php" method="post">
					<label class="title"><b><i>HANDYMAN TOOLS RECEIPT</i></b></label> <br><br>
					<label class="row1"><b>Reservation Number : <b> <?php print $reservationId ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Clerk On Duty : <b> <?php print $clerkName ?> </label> <br><br>
					<label class="row2"><b>Customer Name : <b> <?php print $customerName ?>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Credit Card # : <b> <?php print $creditCard ?> </label> <br><br>
					<label class="row3"><b>Start Date : <b> <?php print $startDate ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>End Date : <b> <?php print $endDate ?> </label> <br><br>
					<label class="row4"><b>Tools Rented : <b></label> <br><br>

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
					<label class="row6"><b>Rental Price : <b><?php print $estimatedRental ?></label> <br><br>
					<label class="row5"><b>Deposit Held : <b><?php print $depositHeld ?></label> <br><br>
					<label class="row7"><b>................................ <b></label> <br><br>

					<label class="row7"><b>Total: &nbsp;&nbsp;&nbsp; <b><?php print $total ?> </label> <br><br>

					<input type="submit" value="Back To Main Menu"" /> <br>

				</form>

			</div>

		</div>

	</body>
</html>


