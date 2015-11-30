<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Schedule Appointment</title>
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
		  
				<div class="button selected">Schedule appointments</div><br>
				<input type="submit" name="next" class="button main selection" value="Print schedule for a day"><br>
				<input type="submit" name="next" class="button main selection" value="Edit appointments"><br>
				<input type="submit" name="next" class="button main selection" value="Search for an appointment"><br>
				<input type="submit" name="next" class="button main selection" value="Create new Admin Account"><br>
			
			</form>
		</div>
		<div id="section">
			<div class="top">
				<h1>Schedule Appointments</h1>
				<h2>Select advising type</h2><br>
				
				<form method="post" action="AdminProcessSchedule.php">
					<div class="nextButton" style="text-align: center;">
						<input type="submit" name="next" class="button large go" value="Individual" style="margin-right: 60px;">
						<input type="submit" name="next" class="button large go" value="Group">
					</div>
				</form>
			<br>
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


