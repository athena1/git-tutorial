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

	if (empty($_POST['toolId'])) {

		$errorMsg = "Please provide a Tool Id.";		

	}

	else{
		$toolId = mysql_real_escape_string($_POST['toolId']);

		$query = "SELECT * FROM tool WHERE ToolId = '$toolId'";

		$result = mysql_query($query);

		if (mysql_num_rows($result) == 0) {

			/* tool not found */
			
			$errorMsg = "Tool not found. Please try a different Tool Id.";
			
		}
		else{
			$row = mysql_fetch_array($result);
			$sellDate = $row['SellDate'];


			if (empty($sellDate) || is_null($sellDate)){
				$reservationClash = false;
				$serviceOrderClash = false;


				$current = date('Y-m-d H:i:s');

				/* checking for reservation clashes */
				
				$query = "SELECT ReservationId FROM reservedtool WHERE ToolId = '$toolId'";

				$result = mysql_query($query);

				while($row = mysql_fetch_array($result)){
					$reservationId = $row['ReservationId'];
					$innerquery = "SELECT StartDate, EndDate FROM reservation where ReservationId = '$reservationId'";

					$innerResult = mysql_query($innerquery);

					$innerrow = mysql_fetch_array($innerResult);

					$tmpDate = $innerrow['StartDate'];
					$startDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					$tmpDate =  $innerrow['EndDate'];
					$endDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					if (($current >= $startDate) && ($current <= $endDate)){
						$reservationClash = true;
					}
				}

				/* checking for service order clashes */
				
				$query = "SELECT StartDate, EndDate FROM serviceorder where ToolId = '$toolId'";

				$result = mysql_query($query);

				while($row = mysql_fetch_array($result)){

					$tmpDate = $row['StartDate'];
					$startDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					$tmpDate =  $row['EndDate'];
					$endDate = date('Y-m-d H:i:s', strtotime($tmpDate));

					if (($current >= $startDate) && ($current <= $endDate)){
						$serviceOrderClash = true;
					}
				}


				if ($reservationClash) {
					$errorMsg = "Current date clashes with an existing reservation of the tool.";

				}
				elseif ($serviceOrderClash) {
					$errorMsg = "Current date clashes with another service order of the tool.";

				}

				else{

					$query = "UPDATE tool SET SellDate='$current' WHERE ToolId = '$toolId'";


					if(mysql_query($query)){
						session_start();

						$_SESSION['toolId'] = $toolId;	
						$_SESSION['clerkId'] = $clerkId;

						header('Location: SellToolConfirm.php');
					}


				}

			}

			else{
				/*  tool already sold */
				$errorMsg = "Tool is already sold.";
			}
		}


	}

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Sell Tool</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

					<form action="SellTool.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Sale Initiation </h1>

						<div class="selltool_form_row">

							<label class="selltool_label">Tool ID:</label>

							<input type="text" name="toolId" class="selltool_input" />

						</div>						
						<input type="submit" value="Enter" /> <br>  					

					</form>

					<?php

					if (!empty($errorMsg)) {

						print "<div class='pickup_form_row' style='color:red'>$errorMsg</div>";

					}

					?>                    
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>