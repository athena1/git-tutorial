<?php

/* connect to database */	
include_once 'dbconnect.php';

session_start();
if (!isset($_SESSION['customerId'])) {
	header('Location: login.php');
	exit();
}


$query = "select Login, Password, FirstName, LastName, Address, WorkPhone, HomePhone, ResId, Start, End, Price, Deposit 
			FROM users JOIN customer ON users.userId = customer.CustomerId 
			JOIN reservationoverview ON customer.CustomerId = reservationoverview.Cust 
		    
			where users.UserId = '{$_SESSION['customerId']}'";
		
$result = mysql_query($query);
if (!$result) {
	print "<p>Error: " . mysql_error() . "</p>";
	exit();
}

$row = mysql_fetch_array($result);
if (!$row) {
	print "<p>Error: No data returned from database.</p>";
	exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>View Profile</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	<body>

		<div id="main_container">
			
			<div class="menu">
				<ul>                                                                         
					<li><a href="viewprofile.php">View Profile</a></li>					    
				</ul>
			</div>
			
			<div class="center_content">
			
				<div class="center">
					
					<div class="features">   
							<div class="profile_section">
							<table border="1" style="width:100%">
								<tr>
									<th class="heading">First Name</th>
									<th class="heading">Last Name</th>
									<th class="heading">Address</th>
									<th class="heading">Work Phone</th>
									<th class="heading">Home Phone</th>
									<th class="heading">Email</th>
									
								</tr>
								<?php								
								
								$query = "select Login, Password, FirstName, LastName, Address, WorkPhone, HomePhone 
											FROM users JOIN customer ON users.userId = customer.CustomerId 
											JOIN reservationoverview ON customer.CustomerId = reservationoverview.Cust 
										 
										 	WHERE users.UserId = '{$_SESSION['customerId']}'";
										 
								$result = mysql_query($query);
								if (!$result) {
									print "<p class='error'>Error: " . mysql_error() . "</p>";
									exit();
								}
								
								$row = mysql_fetch_array($result);
									print "<tr>";
									print "<td>{$row['FirstName']}</td>"; 
									print "<td>{$row['LastName']}</td>";
									print "<td>{$row['Address']}</td>";
									print "<td>{$row['WorkPhone']}</td>";
									print "<td>{$row['HomePhone']}</td>";
									print "<td>{$row['Login']}</td>";
									
									print "</tr>";							
								
												
															
								?>
										
							</table>
							
							<table border="1" style="width:100%">
								<tr>
									<th class="heading">Reservation ID</th>
									<th class="heading">Start Date</th>
									<th class="heading">End Date</th>
									<th class="heading">Price</th>
									<th class="heading">Deposit</th>
								</tr>
								<?php								
								
								$query = "select ResId, Start, End, Price, Deposit 
											FROM users JOIN customer ON users.UserId = customer.CustomerId 
											JOIN reservationoverview ON customer.CustomerId = reservationoverview.Cust 
										 
										 	WHERE users.UserId = '{$_SESSION['customerId']}'";
										 
								$result = mysql_query($query);
								if (!$result) {
									print "<p class='error'>Error: " . mysql_error() . "</p>";
									exit();
								}
								
								while ($row = mysql_fetch_array($result)){
									print "<tr>";
									print "<td>{$row['ResId']}</td>";
									print "<td>{$row['Start']}</td>";
									print "<td>{$row['End']}</td>";
									print "<td>{$row['Price']}</td>";
									print "<td>{$row['Deposit']}</td>";
									print "</tr>";							
								}
												
												
								?>
										
							</table>
							
							<p>
						<div>
							<br><b><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Go Back to MENU</a></b></br>
						</div>
						</p>
							
						</div>
			
					 </div> 
					
				</div> 
				
				<div class="clear"></div> 
			
			</div>    

		</div>

	</body>
</html>