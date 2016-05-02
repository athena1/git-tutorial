<?php
include_once 'dbconnect.php';
session_start ();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/resources/demos/style.css">

</head>
<title>Handyman Tools Reservation Summary</title>

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

				<form action="ResFinal.php" method="post">


					
<?php
$TotalRentalPrice = $_SESSION['totalrentprice'];
 $TotalDepositRequired = 	$_SESSION['totaldeposit'];
if(!empty($_SESSION['check_list'])) {
	echo '<p>Your Reservation Number Is:</p><br>';
	$customerid =$_SESSION['customerId'];
	$startdate = $_SESSION ['start_date'];
	$enddate = $_SESSION ['end_date'];
	$query = "INSERT INTO `reservation`( `CustomerId`, `StartDate`, `EndDate`, `DepositHeld`, `RentalPrice`) VALUES 
	($customerid,'$startdate','$enddate',$TotalDepositRequired,$TotalRentalPrice)";
		
		$result = mysql_query ( $query );
	
	$reservationID = mysql_insert_id();
	echo $reservationID.'<br>';
	
	echo '<p>Tools Reserved:</p><br>';
    foreach($_SESSION['check_list'] as $check) {
		$query = "SELECT * from tool WHERE ToolId=$check";

		
		$result = mysql_query ( $query );
		while ( $row = mysql_fetch_array ( $result ) ) {
			echo $row['AbbrDesc']."<br>";
		}
		
            //this is where we output our tools
    }
	
	foreach($_SESSION['check_list'] as $check) {
		$query = "INSERT INTO `reservedtool`(`ToolId`, `ReservationId`) VALUES ($check,$reservationID)";
		
		$result = mysql_query ( $query );
	}
}
?>
					<p>Start Date: <?php Echo($_SESSION ['start_date']) ?></p>
					<p>End Date: <?php Echo($_SESSION ['end_date']) ?></p>
					<p>Total Rental Price: <?php Echo($TotalRentalPrice) ?></p>
					<p>Total Deposit Required: <?php Echo($TotalDepositRequired)?></p>
			
						<br>  			
						<a href="CustomerMainMenu.html">Back to Main Menu</a>

					<form />

					<?php
					
					if (! empty ( $errorMsg )) {
						
						print "<div class='reservation_form_row' style='color:red'>$errorMsg</div>";
					}
					
					?>                    
						   
				
			
			</div>

			<div class="clear">
				<br />
			</div>

		</div>

	</div>

</body>

</html>
