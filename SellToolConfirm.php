<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

// get from somewhere
$clerkId = "";
$description = "";
$type = "";

$saleprice = 0.0;

session_start();

if (!isset($_SESSION['clerkId'])){
	header('Location: SellTool.php');
	exit();
}


if (!isset($_SESSION['toolId'])){
	header('clerkId: SellTool.php');
	exit();
}

$toolId = $_SESSION['toolId'];
$clerkId = $_SESSION['clerkId'];

$reservationClash = $_SESSION['reservationClash'];
$serviceOrderClash = $_SESSION['serviceOrderClash'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$_SESSION['clerkId'] = $clerkId;

	header('Location: ClerkMainMenu.php');
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Sale Confirmation</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

					<form action="SellToolConfirm.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Sale Confirmation </h1>

						<div class="saleconfirm_form_row">


							<?php

							$query= "SELECT * FROM tool WHERE ToolId = '$toolId'";

							$result = mysql_query($query);
							$row = mysql_fetch_array($result);

							$description = $row['AbbrDesc'];
							$type = $row['Type'];
							$purchaseprice =  $row['Purchase'];

							$saleprice = floatval($purchaseprice) / 2;


							?> 
							<label class="saleconfirm_label"><b> SALE CONFIRMATION </b></label> <br><br>

							<label class="id_label">Tool ID: <?php print $toolId ?></label><br>
							<label class="desc_label">Abbreviated Description: <?php print $description ?></label><br>
							<label class="type_label">Type: <?php print $type ?></label><br>
							<label class="saleprice_label">Sale Price: <?php print $saleprice ?></label><br><br>

						</div>						
						<input type="submit" value="Back to Main Menu" /> <br>  					

				</form>
                   
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>