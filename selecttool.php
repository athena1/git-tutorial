<?php

/* connect to database */	

include_once 'dbconnect.php'; 

mysql_select_db("handyman_tools") or die( "Unable to select database");



$errorMsg = "";

$Start_Date = mysql_real_escape_string($_POST['StartDate']);

$End_Date = mysql_real_escape_string($_POST['EndDate']);

$toolType =  mysql_real_escape_string($_POST['type']);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (empty($_POST['StartDate']) or empty($_POST['EndDate'])) {

		$errorMsg = "Please provide both Start Date and End Date.";

	}

	else{
		session_start();

		$_SESSION['StartDate'] = $Start_Date;	
		$_SESSION['EndDate'] = $End_Date;	
		$_SESSION['Type'] = $toolType;
			
		header('Location: ToolAvailability.php');
		exit();
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Check Availability</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	<body>

<center>
<div id="login-form">
<form method="post">

		<div id="main_container">
			
			<div class="center_content">
			
				<div class="center">					

					<h1 style="color:#cc6600"> Select Tool Category </h1>
					
					<?php 
						if (isset($_POST['Hand'])) {
					
						header('Location: handtoolavailability.php');
						exit();
							
					} 
					
					else if (isset($_POST['Construction'])) {
					
						header('Location: constructiontoolavailability.php');
						exit();
						 
					} 
					
					else if (isset($_POST['Power'])) {
					
						header('Location: powertoolavailability.php');
						exit();
					}	
					
					?>
					
					<div>
					
					<input type="radio" name="type" value="Hand" checked> Hand Tools<br>
					<input type="radio" name="type" value="Construction"> Construction Tools<br>
					<input type="radio" name="type" value="Power">Power Tools<br><br>
					
					</div>
					
					<div>
  									
  							<br><input id="option" type="datetime" name="StartDate" value="Start Date">
  									<label for="option">Start Date</label></br>
					</div>
					
					
					<div>
  							<br><input id="option" type="datetime" name="EndDate" value="End Date">
  									<label for="option">End Date</label></br>
					</div>
					
					<div class= "center">
						<input type="submit" value="Enter" /> <br>
						
					</div>
					</div>
					</div>
					</form>
					</div>
						   
				</div>
					
				<div> <a href="CustomerMainMenu.html">Return to Main Menu</a></div> 
				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>