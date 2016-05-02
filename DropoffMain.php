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
	if (empty($_POST['reservationId'])) {

		$errorMsg = "Please provide a reservation Id.";		

	}
	else{
		$reservationId = mysql_real_escape_string($_POST['reservationId']);

		$query = "SELECT * FROM reservation WHERE ReservationId = '$reservationId'";

		$result = mysql_query($query);

		if (mysql_num_rows($result) == 0) {

			/* reservation not found */
			
			$errorMsg = "Reservation not found. Please try a different reservation id.";
			
		}
		else{
			/* reservation found */
			session_start();

			$_SESSION['reservationId'] = $reservationId;	
			$_SESSION['clerkId'] = $clerkId;			
		

			/* redirect to the profile page */
			header('Location: DropoffConfirm.php');

			exit();


		}
	}







}  

?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Drop Off</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

					<form action="DropoffMain.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Drop Off </h1>

						<div class="dropoff_form_row">

							<label class="dropoff_label">Reservation ID:</label>

							<input type="text" name="reservationId" class="dropoff_input" />

						</div>						
						<input type="submit" value="Enter" /> <br>  					

					</form>

					<?php

					if (!empty($errorMsg)) {

						print "<div class='dropoff_form_row' style='color:red'>$errorMsg</div>";

					}

					?>                    
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>