<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Exit Message</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
	<div class="container">
	<?php
		include('./header.php');
		if(isset($_GET["firstN"])){$firstN = $_GET["firstN"];}
		else{$firstN = $_POST["firstN"];}
		if(isset($_GET["lastN"])){$lastN = $_GET["lastN"];}
		else{$lastN = $_POST["lastN"];}
		if(isset($_GET["email"])){$email = $_GET["email"];}
		else{$email = $_POST["email"];}
		if(isset($_GET["major"])){$major = $_GET["major"];}
		else{$major = $_POST["major"];}
	?>
	<div class="container main">
	<div id="nav">
		<form action="StudProcessHome.php" method="post" name="Home">
		<?php
			echo("<input type=\"hidden\" name=\"firstN\" value=\"$firstN\">");
			echo("<input type=\"hidden\" name=\"lastN\" value=\"$lastN\">");
			echo("<input type=\"hidden\" name=\"email\" value=\"$email\">");
			echo("<input type=\"hidden\" name=\"major\" value=\"$major\">");
			if ($studExist == false || $adminCancel == true || $noApp == true){
				
				echo "<button type='submit' name='selection' class='button main selection' value='Signup'>Signup for an appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Next'>Find the next available appointment</button><br>";
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
	    <div class="statusMessage">
	    <?php
			//display message based on what action was completed
			$_SESSION["resch"] = false;			
			if($_SESSION["status"] == "complete"){
				echo "You have completed your sign-up for an advising appointment.";
			}
			elseif($_SESSION["status"] == "none"){
				echo "You did not sign up for an advising appointment.";
			}
			elseif($_SESSION["status"] == "cancel"){
				echo "You have cancelled your advising appointment.";
			}
			elseif($_SESSION["status"] == "resch"){
				echo "You have changed your advising appointment.";
			}
			elseif($_SESSION["status"] == "keep"){
				echo "No changes have been made to your advising appointment.";
			}
			else{
				echo "An error has occurred.";
			}
		?>
        </div>
		</div>
		<form action="02StudHome.php" method="post" name="complete">
		<?php
			echo("<input type=\"hidden\" name=\"firstN\" value=\"$firstN\">");
			echo("<input type=\"hidden\" name=\"lastN\" value=\"$lastN\">");
			echo("<input type=\"hidden\" name=\"email\" value=\"$email\">");
			echo("<input type=\"hidden\" name=\"major\" value=\"$major\">");
		?>
	    <div class="returnButton">
			<input type="submit" name="return" class="button large go" value="Return to Home">
	    </div>
		</form>
	</div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  </body>
</html>


