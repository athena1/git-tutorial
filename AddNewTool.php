<?php

include_once 'dbconnect.php'; 

mysql_select_db("handyman_tools") or die( "Unable to select database");

$errorMsg = [];


session_start();

if (!isset($_SESSION['clerkId'])){
	header('Location: ClerkMainMenu.php');
	exit();
}

$clerkId = $_SESSION['clerkId'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if (empty($_POST['abbrDesc'])) {
		$errorMsg[] = "Please provide an abbreviated description of the tool.";
	} 
	else { 	
		$abbrDesc = mysql_real_escape_string($_POST['abbrDesc']);
	}

	if (empty($_POST['purchasePrice'])) {
		$errorMsg[] = "Please provide the purchase price of the tool.";		
	}
	else { 
		$purchasePrice = mysql_real_escape_string($_POST['purchasePrice']);	
	}

	if (empty($_POST['rentalPrice'])) {
		$errorMsg[] = "Please provide the daily rental price for the tool.";
	}
	else { 
		$rentalPrice = mysql_real_escape_string($_POST['rentalPrice']);	
	}

	if (empty($_POST['deposit'])) {
		$errorMsg[] = "Please provide the deposit amount required for the tool.";
	}
	else { 
		$deposit = mysql_real_escape_string($_POST['deposit']);	
	}

	if (empty($_POST['fullDesc'])) {
		$errorMsg[] = "Please provide a full description of the tool.";		
	}
	else { 
		$fullDesc = mysql_real_escape_string($_POST['fullDesc']);
	}

	if (empty($_POST['type'])) {
		$errorMsg[] = "Please select a tool type.";
	}
	else { 
		$type = mysql_real_escape_string($_POST['type']);	
	}
	
	$tempAcc = $_POST['accessories'];	
	if ($type == "power"and empty($tempAcc)) {
		$errorMsg[] = "Please provide the list of accessories associated with this power tool.";
	}
	else { 
		
		$accessories = array();
		
		$token = strtok($tempAcc, ",");		
		while ($token !== false) {
			$accessories[] = $token;
			$token = strtok(",");
		}
	}
	
	
	
	if (empty($errorMsg)){
		
		$query1 = "INSERT INTO tool (AbbrDesc, FullDesc, Rental, Deposit, Purchase, Type) " .
				"VALUES('$abbrDesc', '$fullDesc', '$rentalPrice', '$deposit', '$purchasePrice', '$type')";
		
		$toolAccResults = [];
		
		mysql_query("BEGIN"); //begin transaction
		
		$result1 = mysql_query($query1);
		
		if (!$result1) {
			mysql_query("ROLLBACK");   //end transaction
			print '<p class="error">Error: Failed to add tool. ' . mysql_error() . '</p>';
		}
		else{
			$accFailed = FALSE; 
			foreach ($accessories as $accessory) {
				
				$resultAcc = mysql_query("INSERT INTO toolaccessory (ToolId, Accessory) " .
						"VALUES(LAST_INSERT_ID(),'$accessory')");
				
				if (!$resultAcc) {
					mysql_query("ROLLBACK");   //end transaction
					print '<p class="error">Error: Failed to add tool. ' . mysql_error() . '</p>';
					$accFailed = TRUE;
					break;
				}
			}
			if (!$accFailed){
				mysql_query("COMMIT");   //end transaction
			}
		}
	}
}  

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Add New Tool</title>

		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script type="text/javascript">
		function hasAccessories(opt)
		{
		    if (opt == 'power')
		        document.getElementById('acc').disabled = false;
		    else
		        document.getElementById('acc').disabled = true;
		}
	    </script>

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">
				
					<?php

					if (!empty($errorMsg)) {
						echo "<div class='login_form_row' style='color:red'>";						
						echo "<ul>";
						foreach($errorMsg as $e){
							echo '<li>'.$e.'</li>';
						}
						echo "</ul>";						
						echo "</div>";
					}

					?>  

				<form action="AddNewTool.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools - Add New Tool </h1>
						
						<div style='color:gray'>
							<small>*All fields required</small>
						</div>

						<div>
							<label>Abbreviated Description:</label>
							<input type="text" name="abbrDesc" /><br><br>
						</div>

						<div>
							<label>Purchase Price:	$</label>
							<input type="text" name="purchasePrice" /><br><br>
						</div>      

						<div>
							<label>Rental Price: (per day) $</label>
							<input type="text" name="rentalPrice" /><br><br>
						</div> 
						
						<div>
							<label>Deposit Amount:	$</label>
							<input type="text" name="deposit" /><br><br>
						</div> 
						
						<div>
							<label>Full Description:</label><br>
							<textarea rows="4" cols="40" name="fullDesc"> </textarea><br><br>
						</div> 

						<input type="radio" name="type" value="hand" onclick="hasAccessories('hand')"> Hand Tool<br>
						<input type="radio" name="type" value="construction" onclick="hasAccessories('construction')"> Construction Equipment<br>
						<input type="radio" name="type" value="power" onclick="hasAccessories('power')"> Power Tool<br><br>
						
						<div>
							<label>Power Tool Accessories:</label><br>
							<textarea rows="5" cols="50" name="accessories" id="acc" disabled> </textarea><br>
							<label style='color:gray'>Enter a <b>comma seperated list </b>of accessories associated with this Power Tool</label><br>
							<br>
						</div> 
						
						<input type="submit" value="Enter" /> <br>  					

					<form/>

					<?php

					if (!empty($errorMsg)) {
						echo "<div class='login_form_row' style='color:red'>";						
						echo "<ul>";
						foreach($errorMsg as $e){
							echo '<li>'.$e.'</li>';
						}
						echo "</ul>";						
						echo "</div>";
					}

					?>                    
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    
			
			<div> <a href="ClerkMainMenu.php">Return to Main Menu</a></div> 

		</div>

	</body>

</html>
