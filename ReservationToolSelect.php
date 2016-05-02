<?php
include_once 'dbconnect.php';

$errorMsg = "";
$tools = array ();
$_SESSION ['tools'] = $tools;

session_start ();

 if (isset($_POST['start_date'])) { 
 $_SESSION['start_date'] = $_POST['start_date'];
 } 
 
 if (isset($_POST['end_date'])) { 
 $_SESSION['end_date'] = $_POST['end_date'];
 }

  
 $start_date =  $_SESSION['start_date'];
 $end_date =  $_SESSION['end_date'];
if(strtotime($end_date) < strtotime($start_date)){
	header('Location: Reservations.php');
}
$start_date = mysql_real_escape_string ( $_POST ['start_date'] );

$end_date = mysql_real_escape_string ( $_POST ['end_date'] );
mysql_real_escape_string ( $_POST ['end_date'] );
/*
//new code
$toolidlist1 =array();
$toolidlist2 =array();
$toolidlist4 =array();
$toolidlistitnersect =array();
$toolidlist = array();
$query1 = "select DISTINCT(reservedtool.ToolId) from ((reservedtool LEFT JOIN reservation ON reservation.ReservationId=reservedtool.ReservationId) 
LEFT JOIN tool ON tool.ToolId=reservedtool.ToolId) where ((reservation.StartDate NOT between '$start_date' and '$end_date' ) AND 
(reservation.EndDate NOT between '$start_date' and '$end_date' )) AND tool.SellDate IS NULL UNION 
SELECT DISTINCT(tool.ToolId) from tool LEFT JOIN reservedtool ON tool.ToolId=reservedtool.ToolId WHERE tool.SellDate IS NULL  AND
 reservedtool.ReservationId IS NULL";
$result = mysql_query ( $query1 );
if (mysql_num_rows ( $result ) > 0) {
	while ($row = mysql_fetch_array($result)) {
		$toolidlist1[] = $row['ToolId'];
	}
	
}
echo $query1.'<br>';
$query2 = "SELECT DISTINCT(serviceorder.ToolId) FROM serviceorder WHERE ((serviceorder.StartDate  between '$start_date' and '$end_date' )
 OR (serviceorder.EndDate  between '$start_date' and '$end_date' ))";
 $result = mysql_query ( $query2 );
if (mysql_num_rows ( $result ) > 0) {
	while ($row = mysql_fetch_array($result)) {
		$toolidlist2[] = $row['ToolId'];
	}
	
}
echo $query2.'<br>';
$toolidlist = array_diff($toolidlist1,$toolidlist2);
/*

 $query4 = "SELECT tool.ToolId from tool LEFT JOIN reservedtool ON tool.ToolId=reservedtool.ToolId WHERE reservedtool.ReservationId IS NULL";
 $result = mysql_query ( $query4 );
if (mysql_num_rows ( $result ) > 0) {
	while ($row = mysql_fetch_array($result)) {
		$toolidlist4[] = $row['ToolId'];
	}
	
}
echo $query4.'<br>';
$toolidlist = $toolidlistitnersect + $toolidlist4;
*/
//new code

$query = "SELECT DISTINCT(tool.ToolId) from tool LEFT JOIN reservedtool ON tool.ToolId=reservedtool.ToolId LEFT JOIN reservation ON reservedtool.ReservationId=reservation.ReservationId LEFT JOIN serviceorder ON tool.ToolId=serviceorder.ToolId WHERE 
tool.SellDate IS NULL 
AND (reservation.ReservationId IS NULL OR ((reservation.StartDate NOT between '$start_date' and '$end_date' ) AND
(reservation.EndDate NOT between '$start_date' and '$end_date' ))) AND
 (serviceorder.ServiceOrderId IS NULL OR ((serviceorder.StartDate NOT between '$start_date' and '$end_date' ) AND 
 (serviceorder.EndDate NOT between '$start_date' and '$end_date' )))";

$result = mysql_query ( $query );
$toolidlist = array();
	while ( $row = mysql_fetch_array ( $result ) ) {
		$toolidlist[] = $row['ToolId'];
	}
if (mysql_num_rows ( $result ) == 0) {
	
	/* no tools found  */
	
	
		$errorMsg = "No Tools Found,  Please go back and pick a different date.";
	
		//header ( 'Location: Reservations.php' );
	
} 



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>



<head>
<meta charset="utf-8">
  <link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( ".my_datepicker" ).datepicker();
  });
  </script>
</head>
		<title>Handyman Tools Reservations</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo">
				
				<img src="img/tools.jpg" border="0" alt="" title="" />
			
			</div>       

			</div>

			<div class="center_content">

				<div class="text_box">

				<form action="ResSummary.php" method="post">

						<h1 style="color:#cc6600"> Handyman Tools Reservations </h1>
<label >Tool Selection:</label><br>
						<?php
			foreach($toolidlist as $toolid) {
			$query = "SELECT * from tool WHERE ToolId=$toolid";
		
		$result = mysql_query ( $query );
		while ( $row = mysql_fetch_array ( $result ) ) {
			echo '<input type="checkbox" name="check_list[]" value="'.$row["ToolId"].'">'.$row["AbbrDesc"] .'<br>';
		}			
			}

						?>				

					<br><br><input type="submit" value="Submit Tools" /> <br>  			
						<br>  			
						<a href="Reservations.php">Reset reservation</a>
						<br>  		
					
					</form>

					<?php
					
					if (! empty ( $errorMsg )) {
						
						print "<div class='reservation_form_row' style='color:red'>$errorMsg</div>";
					}
					
					?></div>

<div class="clear">
	<br />
</div>

</div>

</div>



</body>

</html>