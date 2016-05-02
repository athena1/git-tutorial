<?php

$sessionStatus = session_status();
if ($sessionStatus == PHP_SESSION_ACTIVE) {

	Session_destroy();
	
}

include_once 'dbconnect.php';

$errorMsg = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (empty($_POST['email']) or empty($_POST['password'])) {

		$errorMsg = "Please provide both email and password.";		

	}
	
	else {  		

		$email = mysql_real_escape_string($_POST['email']);

		$password = mysql_real_escape_string($_POST['password']);
		
		$userType = ($_POST['type']);
		
		
		if ($userType == "clerk") {
			if (strlen($email) <= 16) {
				$query = "SELECT Login, Password, UserId FROM users JOIN clerk ON UserId = ClerkId " .
					"WHERE Login = '$email' AND Password = '$password'";
			}
			else {
				$errorMsg = "Please provide a valid clerk login.";
			}
		}
		else {
		
			if (strpos($email, '@')!== false) {
				$query = "SELECT Login, Password, UserId FROM users JOIN customer ON UserId = CustomerId " .
					"WHERE Login = '$email' AND Password = '$password'";
			}
			else {
				$errorMsg = "Please provide a valid customer login/email address.";
			}
		}

		if (empty($errorMsg)) {
			$result = mysql_query($query);

			if (mysql_num_rows($result) == 0) {

				/* login failed */			
				if ($userType == "clerk") {
					$errorMsg = "Login failed.  Please try again.";
				}			
				else {
					/* redirect to the create profile page */ 
					header('Location: CreateProfile.php');
					exit();
				}
			}
			else {
				/* login successful */
				session_start();
				$row = mysql_fetch_array($result);

				$id = $row['UserId'];

				if ($userType == "clerk") {
					$_SESSION['clerkId'] = $id;
					
					/* redirect to the clerk main menu */
					header('Location: ClerkMainMenu.php');
					exit();
				}
				else {
					$_SESSION['customerId'] = $id;
					
					/* redirect to the customer main menu */
					header('Location: CustomerMainMenu.html');
					exit();
				}
			}		
		}		
	}
}  

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

		<title>Handyman Tools Login</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

				<form action="login.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Login </h1>

						<div class="login_form_row">

							<label >Login:</label>

							<input type="text" name="email" />

						</div>

										

						<div class="login_form_row">

							<label class="login_label">Password:</label>

							<input type="password" name="password" class="login_input" /><br><br>

						</div>                             

						<input type="radio" name="type" value="customer" checked> Customer<br>
						<input type="radio" name="type" value="clerk"> Clerk<br><br>
						
						<input type="submit" value="Enter" /> <br>  					

					<form/>

					<?php

					if (!empty($errorMsg)) {

						print "<div style='color:red'>$errorMsg</div>";

					}

					?>                    
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>