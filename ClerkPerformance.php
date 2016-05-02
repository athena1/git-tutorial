<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'DbConnect.php';

$errorMsg = "";

// get from somewhere
$clerkId = "";

session_start ();

if (!isset($_SESSION['clerkId'])){
	header('Location: GenerateReports.php');
	exit();
}

$clerkId = $_SESSION['clerkId'];
$query = "select DISTINCT ClerkId from clerk";

$result = mysql_query ( $query );


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();

	$_SESSION['clerkId'] = $clerkId;

	header('Location: ClerkMainMenu.php');

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="/resources/demos/style.css">

</head>
<title>Handyman Tools Clerk Performance Report</title>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body>

	<div id="main_container">

		<div id="header">

			<div class="logo">
				<img src="img/tools.jpg" border="0" alt="" title="" />
			</div>

		</div>

		<div class="center_content">

			<div class="text_box">

				<form action="ClerkPerformance.php" method="post">

					<h1 style="color: #cc6600">Handyman Tools Clerk Reports</h1>
					<table>
						<tr>
							<td>Clerk ID</td>
							<td>Pickups</td>
							<td>Dropoffs</td>
							<td>Total</td>
						</tr>
            <?php
												while ( $row = mysql_fetch_array ( $result ) ) {
													$query2 = "SELECT 
    (Select count(*)  from pickup JOIN reservation ON pickup.ReservationId=reservation.ReservationId WHERE pickup.ClerkId=" . $row['ClerkId'] . " AND
     reservation.EndDate  >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) AS pickupCount, 
     (Select count(*)  from dropoff JOIN reservation ON dropoff.ReservationId=reservation.ReservationId WHERE  dropoff.ClerkId=" . $row['ClerkId'] . " AND
      reservation.EndDate  >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) AS DropoffCount";
													$clerkid = $row ['ClerkId'];
													$result2 = mysql_query ( $query2 );
													while ( $row = mysql_fetch_array ( $result2 ) ) {
														echo "<tr>";
														echo "<td>" . $clerkid . "</td>";
														echo "<td>" . $row['pickupCount'] . "</td>";
														echo "<td>" . $row['DropoffCount'] . "</td>";
														$total = $row['pickupCount'] + $row['DropoffCount'];
														echo "<td>" . $total . "</td>";
														echo "</tr>";
													}
												}
												
												?>
												</table>
						<input type="submit" value="Back To Main Menu" /> <br>  					

					<form />

						</div>

						<div class="clear">
							<br />
						</div>

						</div>

						</div>

</body>

</html>