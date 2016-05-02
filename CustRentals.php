<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

session_start();
if (!isset($_SESSION['clerkId'])){
	header('Location: GenerateReports.php');
	exit();
}


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

				<form action="CustRentals.php" method="post">

					<h1 style="color:#cc6600"> Handyman Tools Inventory Report </h1>

					<div>
						
						<table border="1" style="width:100%">
							<tr>
							    <td><b>Last Name</b></td>
							    <td><b>First Name</b></td>		
							    <td><b>Email</b></td>
							    <td><b>Total Rentals</b></td>
								<td><b>Total Number of Tools Rented</b></td>
							</tr>
						
						<?php

							$query1 = "SELECT CustomerId, COUNT(*), LastName, FirstName, Login FROM reservation JOIN users ON CustomerId = UserId " .
										"WHERE EndDate >= NOW() - INTERVAL 30 DAY GROUP BY CustomerId ORDER BY COUNT(*), LastName";
							$result1 = mysql_query($query1);

							while($row = mysql_fetch_array($result1)){
								$custId = $row['CustomerId'];							
								$numRentals = $row['COUNT(*)'];
								$lname = $row['LastName'];
								$fname = $row['FirstName'];
								$login = $row['Login'];
								$sumTools = 0;
						
						
								$reservationQ = "SELECT ReservationId FROM reservation WHERE EndDate >= NOW() - INTERVAL 30 DAY AND CustomerId = $custId";
								$result2 = mysql_query($reservationQ);
								
								while($row2 = mysql_fetch_array($result2)){
									$resId = $row2['ReservationId'];
									
									$toolsQ = "SELECT ReservationID, COUNT(*) FROM reservedTool Where ReservationId = $resId";
									$resultNT = mysql_query($toolsQ);								  
									$rowNT = mysql_fetch_array($resultNT);
									$sumTools += intval($rowNT['COUNT(*)']);						
								}
							echo "<tr><td>$lname</td><td>$fname</td><td>$login</td><td>$numRentals</td><td>$sumTools</td></tr>";
							}
							?>
						</table>
						
					</div>	
						
						<input type="submit" value="Back To Main Menu" /> <br>  					

				</form>                  
						   
			</div>

			<div class="clear"><br/></div> 

		</div>

	</body>

</html>