<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>

  </head>
  <body>
	<div class="container">
	<?php
		include('./header.php');
		
		$debug = false;

		if(isset($_POST["advisor"])){
			$_SESSION["advisor"] = $_POST["advisor"];
		}

		$localAdvisor = $_SESSION["advisor"];
		$localMaj = $_SESSION["major"];

		$sql = "select * from Proj2Advisors where `id` = '$localAdvisor'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		$advisorName = $row[1]." ".$row[2];
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
		<h1>Select Appointment Time</h1>
	    <div class="field">
		<form action = "10StudConfirmSch.php" method = "post" name = "SelectTime">
	    <?php

			// http://php.net/manual/en/function.time.php fpr SQL statements below
			// Comparing timestamps, could not remember. 

			$curtime = time();
			$apptCount = 0;

			if ($_SESSION["advisor"] != "Group")  // for individual appointments only
			{ 
				//get all available times
				$sql = "select * from Proj2Appointments where $temp `EnrolledNum` = 0 
					and (`Major` like '%$localMaj%' or `Major` = '') and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` = ".$_POST['advisor']." 
					order by `Time` ASC limit 30";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				echo "<h2>Individual Advising</h2><br>";
				echo "<label for='prompt' style='padding: 10px 0px;'>Select appointment with ",$advisorName,":</label>";
			}
			else // for group appointments
			{
				$temp = "";
				if($localAdvisor != "Group") { $temp = "`AdvisorID` = '$localAdvisor' and "; }
				//query: get all open group appts
				$sql = "select * from Proj2Appointments where $temp `EnrolledNum` < `Max` and `Max` > 1 and (`Major` like '%$localMaj%' or `Major` = '')  and `Time` > '".date('Y-m-d H:i:s')."' order by `Time` ASC limit 30";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				echo "<h2>Group Advising</h2><br>";
				echo "<label for='prompt' style='padding: 10px 0px;'>Select appointment:</label>";
			}
			//for each result, create a radio button
			while($row = mysql_fetch_row($rs)){
				$datephp = strtotime($row[1]);
				echo "<label for='",$row[0],"' style='padding: 5px 0px;'>";
				echo "<input id='",$row[0],"' type='radio' name='appTime' required value='", $row[1], "'>", date('l, F d, Y g:i A', $datephp) ,"</label>\n";
				$apptCount++;
			}
			//if none were found, print message and DON'T display the submit button
			if ($apptCount == 0)
			{
				echo "<p style=\"color:red\">No more appointments are available.</p>";
				$_SESSION["advisor"] = "Group";
			}
			else
			{
				echo "</div>";
				echo "<div class=\"nextButton\">";
				echo "<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Next\">";
				echo "</div>";
			}
		?>
		</form>
		<div class="bottom">
		<br>
		<p>Note: Appointments are maximum 30 minutes long.</p>
		<p style="color:red">If there are no more open appointments, contact your advisor or click <a href='02StudHome.php'>here</a> to start over.</p>
		</div>
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

        