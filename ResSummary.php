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


					<p>Reservation Summary:</p>

					<p>Tools Desired:</p>
<?php
$TotalRentalPrice = 0;
$TotalDepositRequired = 0;
if(!empty($_POST['check_list'])) {
	$_SESSION['check_list'] = $_POST['check_list'];
    foreach($_POST['check_list'] as $check) {
		$query = "SELECT * from tool WHERE ToolId=$check";
		
		$result = mysql_query ( $query );
		while ( $row = mysql_fetch_array ( $result ) ) {
			echo $row['AbbrDesc']."<br>";
			$TotalRentalPrice = $TotalRentalPrice + $row['Rental'];
			$TotalDepositRequired = $TotalDepositRequired + $row['Deposit'];
		}
		
            //this is where we output our tools
    }
	$_SESSION['totalrentprice'] = $TotalRentalPrice;
	$_SESSION['totaldeposit'] = $TotalDepositRequired;
}
?>
					<p>Start Date: <?php Echo($_SESSION ['start_date']) ?></p>
					<p>End Date: <?php Echo($_SESSION ['end_date']) ?></p>
					<p>Total Rental Price: <?php Echo($TotalRentalPrice) ?></p>
					<p>Total Deposit Required: <?php Echo($TotalDepositRequired)?></p>
<br><br><input type="submit" value="Submit Reservation" /> <br>  			
						<br>  			
						<a href="Reservations.php">Reset</a>

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
