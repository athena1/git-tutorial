<?php 


$errorMsg = "";

session_start();

	?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( ".my_datepicker" ).datepicker( "option", "altFormat", "yyyy-mm-dd" );
  });
  </script>
</head>
		<title>Handyman Tools Reservations</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	<body>

		<div id="main_container">

			<div id="header">

				<div class="logo"><img src="img/tools.jpg" border="0" alt="" title="" /></div>       

			</div>

			<div class="center_content">

				<div class="text_box">

				<form action="ReservationToolSelect.php" method="post" >

						<h1 style="color:#cc6600"> Handyman Tools Reservations </h1>

						<div class="reservation_form_row">

							<label class="start_date_label">Start Date:</label>

							<input type="text" name="start_date"  />

						</div>
										

						<div class="reservation_form_row">

							<label class="end_date_label">End Date:</label>

							<input type="text" name="end_date"/><br><br>

						</div>                             

						
						<input type="submit" value="Submit"  /> <br>  			
						<br>  			
						<br>  		
					
						</form>

					<?php

					if (!empty($errorMsg)) {

						print "<div class='reservation_form_row' style='color:red'>$errorMsg</div>";

					}

					?>                    
						   
				</div>

				<div class="clear"><br/></div> 

			</div>    

		</div>

	</body>

</html>