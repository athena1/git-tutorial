<?php

/* connect to database */	

include_once 'dbconnect.php';

$LoginId = mysql_real_escape_string($_POST['LoginId']);
$Password = mysql_real_escape_string($_POST['Password']);
$FirstName = mysql_real_escape_string($_POST['FirstName']);
$LastName = mysql_real_escape_string($_POST['LastName']);
$Address = mysql_real_escape_string($_POST['Address']);
$HomePhone = mysql_real_escape_string($_POST['HomePhone']);
$WorkPhone = mysql_real_escape_string($_POST['WorkPhone']);
$confirm_password = mysql_real_escape_string($_POST['confirm_password']);

if ($_POST["Password"] != $_POST["confirm_password"]) {
	echo "Password is incorrect :(";
}

elseif (($_POST["HomePhone"] == "") && ($_POST["WorkPhone"] == "")) {
	echo "Both Home Phone and Work Phone cannot be blank :(";
}
else{
	$add_to_users_query = "insert into users (Login, Password, FirstName, LastName) values ('$LoginId', '$Password', '$FirstName', '$LastName')";
	mysql_query($add_to_users_query);
	/*$last_inserted_mysql_id = mysql_insert_id();*/
	$add_to_customer_query = "insert into customer (Address, WorkPhone, HomePhone,customerId) values ('$Address', '$WorkPhone', '$HomePhone',LAST_INSERT_ID())";
	mysql_query($add_to_customer_query);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Profile</title>
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="50%" border="0">
<tr>
<td><input type="email" name="LoginId" placeholder="User Name or Login Id" required /></td>
</tr>
<tr>
<td><input type="password" name="Password" placeholder="Password" required /></td>
</tr>
<tr>
<td><input type="password" name="confirm_password" placeholder="Confirm Password" required /></td>
</tr>
<tr>
<td><input type="text" name="FirstName" placeholder="FirstName" required /></td>
</tr>
<tr>
<td><input type="text" name="LastName" placeholder="LastName" required /></td>
</tr>
<tr>
<td><input type="text" name="Address" placeholder="Address" required /></td>
</tr>
<tr>
<td><input type="text" name="HomePhone" placeholder="HomePhone" /></td>
</tr>
<tr>
<td><input type="text" name="WorkPhone" placeholder="WorkPhone" /></td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Submit</button></td>
</tr>
<tr>
<td><?php header('location : login.php') ?>
<br><b><a href="login.php">Go Back to Login<a/></b></br></td>
</tr>
</table>
</form>

</div>
</center>
</body>
</html>