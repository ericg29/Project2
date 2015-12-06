<?php 
session_start();
if($debug) { echo("Session variables-> ".var_dump($_SESSION)); }
$_SESSION["PassCon"] = false;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Home</title>
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
			<input type="submit" name="next" class="button main selection" value="Print schedule for a day"><br>
			<input type="submit" name="next" class="button main selection" value="Edit appointments"><br>
			<input type="submit" name="next" class="button main selection" value="Search for an appointment"><br>
			<input type="submit" name="next" class="button main selection" value="Create new Admin Account"><br>
		
		</form>
	</div>
	<div id="section">
		<h1>Welcome to COEIT Advising</h1>
		<?php
			if($adminCancel == true){
				echo "<p style='color:red'>The advisor has cancelled your appointment! Please schedule a new appointment.</p>";
			}
		?>
	</div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
</body>
</html>
