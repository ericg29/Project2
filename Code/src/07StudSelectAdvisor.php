<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Advisor</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
	<div class="container">
	<?php
		include('../header.php');
	?>
	<div class="container main">
	<div id="nav">
		<form action="StudProcessHome.php" method="post" name="Home">
		<?php
			if ($studExist == false || $adminCancel == true || $noApp == true){
				
				echo "<div class='button selected'>Signup for an appointment</div><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Next'>Find the next available appointment</button><br>";
			}
			else{
				echo "<button type='submit' name='selection' class='button main selection' value='View'>View my appointment</button><br>";
				echo "<div class='button selected'>Reschedule my appointment</div><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Cancel'>Cancel my appointment</button><br>";
			}
			echo "<button type='submit' name='selection' class='button main selection' value='Search'>Search for appointment</button><br>";
			echo "<button type='submit' name='selection' class='button main selection' value='Edit'>Edit student information</button><br>";
		?>
		</form>
	</div>
	<div id="section">
        <div class="top">
		<h1>Individual Advising</h1>
		<h2>Select Advisor</h2>
		<form action="08StudSelectTime.php" method="post" name="SelectAdvisor" style="margin-bottom: 5px">
	    <div class="field">
	    <?php
			//get advisors table
			$sql = "select * from Proj2Advisors";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//for each advisor, create a radio button
			while($row = mysql_fetch_row($rs)){
				echo "<label for='",$row[0],"' style='padding: 5px 0px;'><input id='",$row[0],"' type='radio' name='advisor' required value='", $row[0],"'>", $row[1]," ", $row[2],"</label>";
			}
		?>
        </div>
	    <div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Next">
	    </div>
		</form>
		</div>
		<div>
		<form method="link" action="02StudHome.php">
		<input type="submit" name="home" class="button large" value="Cancel">
		</form>
		</div>
	</div>
	</div>
	<?php
		include('../footer.php');
	?>
	</div>
  </body>
</html>