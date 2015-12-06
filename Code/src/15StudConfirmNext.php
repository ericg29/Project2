<?php
session_start();
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Find Next Available Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>  </head>
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
        <div class="top" style="text-align: center;">
		<h1>Find Next Available Appointment</h1>
	    <div class="field">
		<form action = "StudProcessSch.php" method = "post" name = "SelectTime">
	    <?php			
			$_SESSION["type"] = $_POST["type"];
			//get variables
			$studid = $_SESSION["studID"];
			$major = $_SESSION["major"];
			$type = $_SESSION["type"];			
			$sql = "";
			
			//query: select soonest appt after the current time that's not full
			//if group appt, advisorID = 0
			if ($type == "Group"){
				$sql = "SELECT *
						FROM  `Proj2Appointments` 
						WHERE  `Time` >  NOW()
						AND  `Major` LIKE  '%$major%'
						AND  `EnrolledNum` <  `Max` 
						AND  `AdvisorID` = 0
						ORDER BY  `Time` ASC 
						LIMIT 0 , 30";
			}
			//otherwise advisorID > 0
			else{
				$sql = "SELECT * 
						FROM  `Proj2Appointments` 
						WHERE  `Time` >  NOW()
						AND  `Major` LIKE  '%$major%'
						AND  `EnrolledNum` <  `Max` 
						AND  `AdvisorID` > '0'
						ORDER BY  `Time` ASC 
						LIMIT 0 , 30";
			}
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//if a row was fetched
			if ($row = mysql_fetch_row($rs))
			{
				//get the appt time and advisor ID
				$timephp = strtotime($row[1]);
				$_SESSION["appTime"] = $row[1];
				$advisorID = $row[2];
			
				if($advisorID != 0){
					//get advisor info
					$sql2 = "select * from Proj2Advisors where `id` = '$advisorID'";
					$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
					$row2 = mysql_fetch_row($rs2);
					$advisorName = $row2[1] . " " . $row2[2];
					$location = $row2[5];
					$meetingLoc = $row2[6];
					$_SESSION["advisor"] = $row2[0];
				}
				else{
					//set group advisor info
					$_SESSION["advisor"] = "Group";
					$advisorName = "Group";
					$location = "ITE200";
				}
				
				//print appt info
				echo "<h2>Confirm Appointment</h2>";
				echo "<br><label for='newinfo' style='font-weight: normal;'>";
				echo "<b>Advisor</b>: ",$advisorName,"<br>";
				echo "<b>Appointment</b>: ",date('l, F d, Y g:i A', $timephp), "<br>";
				echo "<b>Location</b>: ", $location, "<br>";
				echo "<b>Meeting Location</b>: ", $meetingLoc, "</label>";
			
				//print submit button
				echo "</div>";
				echo "<div class=\"nextButton\"><div>";
				echo "<input type=\"submit\" name=\"finish\" class=\"button large go\" value=\"Submit\" style=\"width: 90px; margin-right: 30px;\">";
			}
			//if no appt available
			else
			{
				echo "<p style=\"color:red\">No more appointments are available.</p>";
				$_SESSION["advisor"] = "unavailable";
			}
		?>
		<input type='submit' name='finish' class='button large' value='Cancel' style='width: 90px;'>
		</div>
	    </div>
		</form>
		<br>
		</div>
	</div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  </body>
</html>

