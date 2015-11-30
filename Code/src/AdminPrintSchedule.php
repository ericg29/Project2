<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Print Schedule</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
    <div class="container">
		<?php
			include('./header.php');
		?>
		<div class="container admin">
		<div id="nav">
			<form action="AdminProcessUI.php" method="post" name="UI">
		  
				<input type="submit" name="next" class="button main selection" value="Schedule appointments"><br>
				<div class="button selected">Print schedule for a day</div><br>
				<input type="submit" name="next" class="button main selection" value="Edit appointments"><br>
				<input type="submit" name="next" class="button main selection" value="Search for an appointment"><br>
				<input type="submit" name="next" class="button main selection" value="Create new Admin Account"><br>
			
			</form>
		</div>
		<div id="section">
			<div class="top">
			<h1>Print Schedule</h1>
			  <form action="AdminPrintResults.php" method="post" name="Confirm">
				 <div class="field small">
					 <label for="date">Date</label>
				 <input id="date" type="date" name="date" placeholder="mm/dd/yyyy" required autofocus> (mm/dd/yyyy)
				 </div>

				 <div class="field small">
					<label for="Type">Type of Appointment</label>
				<select id="type" name = "type">
						<option>Both</option>
						<option>Individual</option>
						<option>Group</option>
					</select>
				 </div>

				 <br>

				<div class="nextButton">
					<input type="submit" name="next" class="button large go" value="Next">
			</form>
			</div>
			</div>
			<form method="link" action="AdminUI.php">
				<input type="submit" name="home" class="button large" value="Cancel">
			</form>
		</div>
		</div>
		<?php
			include('./footer.php');
		?>
	</div>
  </body>
</html>


