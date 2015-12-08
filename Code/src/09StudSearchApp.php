<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Search for Appointment</title>
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
			echo "<div class='button selected'>Search for appointment</div><br>";
			echo "<button type='submit' name='selection' class='button main selection' value='Edit'>Edit student information</button><br>";
		?>
		</form>
	</div>
	<div id="section">
        <div class="top">
		<h1>Search for Appointments</h1>
	    <div class="field">
		<form action="11StudSearchResult.php" method="post" name="SearchApp">
			<?php
				echo("<input type=\"hidden\" name=\"firstN\" value=\"$firstN\">");
				echo("<input type=\"hidden\" name=\"lastN\" value=\"$lastN\">");
				echo("<input type=\"hidden\" name=\"email\" value=\"$email\">");
				echo("<input type=\"hidden\" name=\"major\" value=\"$major\">");
			?>
			<label for="date" style="margin-top: 5px;">Date</label>
	      	<input id="date" type="date" name="date" placeholder="mm/dd/yyyy" autofocus> (mm/dd/yyyy)
			
			<label for="time" style="margin-top: 5px;">Time</label><span style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
			<input type="checkbox" name="time[]" value="8:00:00"> 8:00am - 8:30am<br>
			<input type="checkbox" name="time[]" value="8:30:00"> 8:30am - 9:00am<br>
			<input type="checkbox" name="time[]" value="9:00:00"> 9:00am - 9:30am<br>
			<input type="checkbox" name="time[]" value="9:30:00"> 9:30am - 10:00am<br>
			<input type="checkbox" name="time[]" value="10:00:00"> 10:00am - 10:30am<br>
			<input type="checkbox" name="time[]" value="10:30:00"> 10:30am - 11:00am<br>
			<input type="checkbox" name="time[]" value="11:00:00"> 11:00am - 11:30am<br>
			<input type="checkbox" name="time[]" value="11:30:00"> 11:30am - 12:00pm<br>
			<input type="checkbox" name="time[]" value="12:00:00"> 12:00pm - 12:30pm<br>
			<input type="checkbox" name="time[]" value="12:30:00"> 12:30pm - 1:00pm<br>
			<input type="checkbox" name="time[]" value="13:00:00"> 1:00pm - 1:30pm<br>
			<input type="checkbox" name="time[]" value="13:30:00"> 1:30pm - 2:00pm<br>
			<input type="checkbox" name="time[]" value="14:00:00"> 2:00pm - 2:30pm<br>
			<input type="checkbox" name="time[]" value="14:30:00"> 2:30pm - 3:00pm<br>
			<input type="checkbox" name="time[]" value="15:00:00"> 3:00pm - 3:30pm<br>
			<input type="checkbox" name="time[]" value="15:30:00"> 3:30pm - 4:00pm<br></span>

			<label for="advisor" style="margin-top: 5px;">Advisor</label>
	      	<select id="advisor" name="advisor">
				<option value="">All appointments</option>
				<option value="I">Individual appointments</option>
				<option value="0">Group appointments</option>
				<?php
				//get advisor names
				$sql = "select * from Proj2Advisors";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				while($row = mysql_fetch_row($rs)){
					echo "<option value='$row[0]'>$row[1] $row[2]</option>";
				}
				?>
			</select>
        </div>
	    <div class="nextButton">
			<input type="submit" name="go" class="button large go" value="Go">
	    </div>
		</form>
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