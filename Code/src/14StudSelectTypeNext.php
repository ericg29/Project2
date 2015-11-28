<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Advising Type</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
	<div class="container">
	<?php
		include('./header.php');
	?>
	<div class="container main">
	<div id="nav">
		<form action="StudProcessHome.php" method="post" name="Home">
		<?php
			if ($studExist == false || $adminCancel == true || $noApp == true){
				
				echo "<button type='submit' name='selection' class='button main selection' value='Signup'>Signup for an appointment</button><br>";
				echo "<div class='button selected'>Find the next available appointment</div><br>";
			}
			else{
				echo "<button type='submit' name='selection' class='button main selection' value='View'>View my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Reschedule'>Reschedule my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Cancel'>Cancel my appointment</button><br>";
			}
			echo "<button type='submit' name='selection' class='button main selection' value='Search'>Search for appointment</button><br>";
			echo "<button type='submit' name='selection' class='button main selection' value='Edit'>Edit student information</button><br>";
		?>
		</form>
	</div>
	<div id="section">
      <div class="top">
		<h1>Find Next Available Appointment</h1>
		<h2>What kind of advising appointment would you like?</h2><br>
		<form action="15StudConfirmNext.php" method="post" name="SelectType" style="text-align: center;">
	<div class="nextButton" style="text-algin: center;">
		<input type="submit" name="type" class="button large go" value="Individual" style="margin-right: 60px;">
		<input type="submit" name="type" class="button large go" value="Group">
	    </div>
		</form>
		<br>
		<br>
		</div>
		<div>
		<form method="link" action="02StudHome.php">
		<input type="submit" name="home" class="button large" value="Cancel">
		</form>
		</div>
	  </div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  </body>
</html>



  