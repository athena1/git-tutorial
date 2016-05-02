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
	$report = $_POST['report'];  
	if ($report == "inventory") {  
		/* redirect to inventory report*/
		session_start();

		$_SESSION['clerkId'] = $clerkId;			

		header('Location: InventoryReport.php');
	}
	elseif($report == "customer"){
		/* redirct to customer report */
		session_start();

		$_SESSION['clerkId'] = $clerkId;

		header('Location: CustRentals.php');
	}
	else {
		/* redirect to clerk report */
		session_start();

		$_SESSION['clerkId'] = $clerkId;

		header('Location: ClerkPerformance.php');
	} 

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Report Generator</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

					<form action="GenerateReports.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Report Types </h1>

						<div class="report_types">
							 <input type="radio" name="report" value="inventory" checked />Inventory<br />
							 <input type="radio" name="report" value="customer" />Customer Rental<br />
							 <input type="radio" name="report" value="clerk" />Clerk Progress<br />
						</div>						
						<input type="submit" value="Generate Report" /> <br>  					

					</form>
 
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>