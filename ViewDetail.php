<?php

include_once 'dbconnect.php';

$errorMsg = "";

session_start();


if (!isset($_SESSION['toolid'])){
	header('clerkId: PickupMain.php');
	exit();
}

if (!isset($_SESSION['type'])){
	header('clerkId: PickupMain.php');
	exit();
}


$toolid = $_SESSION['toolid'];
$type = $_SESSION['type'];


$reservationId = "";
$clerkId = "";


if (($type == "pickup") || ($type == "dropoff")){

	if (!isset($_SESSION['clerkId'])){
		header('Location: ClerkMainMenu.php');
		exit();
	}

	if (!isset($_SESSION['reservationId'])){
		header('Location: ClerkMainMenu.php');
		exit();
	}

	
	$reservationId = $_SESSION['reservationId'];
	$clerkId = $_SESSION['clerkId'];

}



$AbbrDesc = "";
$FullDesc = "";
$Rental = "";
$Deposit = "";
$Purchase= "";
$Type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($type == 'pickup'){



		$_SESSION['reservationId'] = $reservationId;
		$_SESSION['clerkId'] = $clerkId;

		header('Location: PickupConfirm.php');

		exit();
	}
    elseif ($type == 'dropoff'){


		$_SESSION['reservationId'] = $reservationId;
		$_SESSION['clerkId'] = $clerkId;

		header('Location: DropOffConfirm.php');

		exit();
	}
	else{

		header('Location: selecttool.php');

		exit();

	}

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tool Details</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="toolDetails">

				<?php

				$query = "SELECT * FROM tool WHERE ToolId = '$toolid'";

				$result = mysql_query($query);

				$row = mysql_fetch_array($result);

				$AbbrDesc = $row['AbbrDesc'];
				$FullDesc = $row['FullDesc'];
				$Rental = $row['Rental'];
				$Deposit = $row['Deposit'];
				$Type = $row['Type'];

				
				?>

				<form action="ViewDetail.php" method="post">
				
					<label class="toolId_label"><b>Tool Id: </b> <?php print $toolid ?></label> <br>
					<label class="abbrDesc_label"><b> Abbreviated Description: </b> <?php print $AbbrDesc ?></label> <br>
					<label class="fullDesc_label"><b>Full Description: </b> <?php print $FullDesc ?></label> <br>
					<label class="rental_label"><b>Rental Price Per Day: </b> <?php print $Rental ?></label> <br>
					<label class="deposit_label"><b>Deposit: </b><?php print $Deposit ?></label> <br>
					<label class="type_label"><b>Type: </b><?php print $Type ?></label> <br><br>

					<?php

					if ($Type == "Power"){
						$query2 = "SELECT * FROM toolaccessory WHERE ToolId = '$toolid'";
						$result2 = mysql_query($query2);
						print "<label class='accessories'><i> Accessories </i></label> <br><br>";

						while($row2 = mysql_fetch_array($result2)){
							$name = $row2['Accessory'];
							print "<label class='accessory_bullet'>- $name</label> <br>";

						}

					}


					?>

					<input type="submit" value="Back" /> 					


				</form>




			</div>
		</div>
	</body>

</html>