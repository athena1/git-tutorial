<?php

/* connect to database */



include_once 'dbconnect.php'; 

mysql_select_db("handyman_tools") or die( "Unable to select database");
$toolDetailerrorMsg = "";

session_start();

$start_date =  $_SESSION['StartDate'];
$end_date =  $_SESSION['EndDate'];
$tool_type =  $_SESSION['Type'];


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	if (empty($_GET['toolId'])) {

		$toolDetailerrorMsg = "Please provide a tool id.";

	}
	else{
		$toolid = mysql_real_escape_string($_GET['toolId']);

		$query = "SELECT * FROM tool WHERE ToolId = '$toolid'";

		$result = mysql_query($query);

		if (mysql_num_rows($result) == 1) {


			$_SESSION['toolid'] = $toolid;
			$_SESSION['type'] = 'power';


			/* redirect to the profile page */
			header('Location: ViewDetail.php');

			exit();
		}

		else{
			$toolDetailerrorMsg = "Tool not found. Please try another id.";


		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Tool Availability</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	<body>

		<div id="main_container">
				
			<div class="center_content">
			
				<div class="center">
				
				<h1 style="color:#cc6600"> Tool Availability </h1>
					
					<div class="features">   
							<div class="profile_section">
							<table border="1" style="width:100%">
								<tr>
									<th class="heading">ToolID</th>
									<th class="heading">Abbr. Description</th>
									<th class="heading">Deposit</th>
									<th class="heading">Price ($)</th>
									
								</tr>
								<?php	

								$start_date = $_SESSION['StartDate'];
								$end_date = $_SESSION['EndDate'];	
								$tool_type =  $_SESSION['Type'];
						
								
								$query = "SELECT DISTINCT(tool.ToolId) from tool LEFT JOIN reservedtool ON tool.ToolId=reservedtool.ToolId LEFT JOIN reservation ON reservedtool.ReservationId=reservation.ReservationId LEFT JOIN serviceorder ON tool.ToolId=serviceorder.ToolId WHERE 
tool.SellDate IS NULL 
AND (reservation.ReservationId IS NULL OR ((reservation.StartDate NOT between '$start_date' and '$end_date' ) AND
(reservation.EndDate NOT between '$start_date' and '$end_date' ))) AND
 (serviceorder.ServiceOrderId IS NULL OR ((serviceorder.StartDate NOT between '$start_date' and '$end_date' ) AND 
 (serviceorder.EndDate NOT between '$start_date' and '$end_date' ))) AND tool.Type = '$tool_type'";
; 					
										 
								$result = mysql_query($query);
								if (!$result) {
									print "<p class='error'>Error: " . mysql_error() . "</p>";
									exit();
								}
								
								while ($row = mysql_fetch_array($result)){
									$toolid = $row['ToolId'];

									$query = "SELECT * from tool WHERE ToolId=$toolid";
		
									$result2 = mysql_query ( $query );
									while ( $row = mysql_fetch_array ( $result2 ) ) {
										print "<tr>";
										print "<td>{$row['ToolId']}</td>"; 
										print "<td>{$row['AbbrDesc']}</td>";
										print "<td>{$row['Deposit']}</td>";
										print "<td>{$row['Rental']}</td>";
										
										print "</tr>";			
									}


													
								}
												
															
								?>
										
							</table>
						
						<p>

						<form action="powertoolavailability.php" method="get">
							<label class="toolId_label">Tool Id: </label>

							<input type="text" name="toolId" class="viewDetail_input" />

							<input type="submit" value="View Details" /> <br> <br> 		

							<?php

							if (!empty($toolDetailerrorMsg)) {

								print "<div class='tool_detail_row' style='color:red'>$toolDetailerrorMsg</div>";

							}

							?>     			


						</form>
						<div>
							<br><b><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Go Back to Select Tool</a></b></br>
						</div>
						</p>
					 </div> 
					
					
					
				</div> 
				
				<div class="clear"></div> 
			
			</div>    

		</div>

	</body>
</html>