<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

$errorMsg = "";


session_start();

if (!isset($_SESSION['clerkId'])){
	header('Location: login.php');
	exit();
}

$clerkId = $_SESSION['clerkId'];


// handle the two form submits


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  	$button =  $_POST['submit'];

  	if ($button == "Pick Up"){
  		session_start();
		$_SESSION['clerkId'] = $clerkId;
		header('Location: PickupMain.php');

		exit();

  	} elseif ($button == "Drop Off"){
  		session_start();
		$_SESSION['clerkId'] = $clerkId;
		header('Location: DropoffMain.php');

		exit();

  	} elseif ($button == "Service Order"){
  		session_start();
		$_SESSION['clerkId'] = $clerkId;
		header('Location: ServiceOrder.php');

		exit();

  	} elseif ($button == "Add New Tool"){
  		session_start();
		$_SESSION['clerkId'] = $clerkId;
		header('Location: AddNewTool.php');

		exit();

  	} elseif ($button == "Sell Tool"){
  		session_start();
		$_SESSION['clerkId'] = $clerkId;
		header('Location: SellTool.php');

		exit();

  	} elseif ($button == "Generate Reports"){
  		session_start();
		$_SESSION['clerkId'] = $clerkId;
		header('Location: GenerateReports.php');

		exit();

  	} else{
  		session_start();
		header('Location: login.php');

		exit();

  	}




}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools - Clerk Main Menu</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

						<h1 style="color:#cc6600"> Main Menu </h1>

						<form action="ClerkMainMenu.php" method="post">

							<input id="pickup-submit" type="submit" name="submit" value="Pick Up"><br><br>
   							<input id="dropoff-submit" type="submit" name="submit" value="Drop Off"><br><br>
   							<input id="serviceorder-submit" type="submit" name="submit" value="Service Order"><br><br>
   							<input id="addtool-submit" type="submit" name="submit" value="Add New Tool"><br><br>
   							<input id="selltool-submit" type="submit" name="submit" value="Sell Tool"><br><br>
   							<input id="generatereport-submit" type="submit" name="submit" value="Generate Reports"><br><br>
   							<input id="exit-submit" type="submit" name="submit" value="Exit"><br><br>

						</form>      

				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>