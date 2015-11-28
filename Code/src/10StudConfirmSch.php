<?php
session_start();
$_SESSION["appTime"] = $_POST["appTime"]; // radio button selection from previous form
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Confirm Appointment</title>
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
	<div class="top" style="text-align: center;">
		<h1>Confirm Appointment</h1>
	    <div class="field">
		<form action = "StudProcessSch.php" method = "post" name = "SelectTime">
	    <?php
			$studid = $_SESSION["studID"];
			
			//if the appt is being REscheduled
			if($_SESSION["resch"] == true){
				//query: get the appt that matches the student ID
				$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$row = mysql_fetch_row($rs);
				//get old appt info
				$oldAdvisorID = $row[2];
				$oldDatephp = strtotime($row[1]);
				
				if($oldAdvisorID != 0){
					//if not a group appt, get the advisor's name
					$sql2 = "select * from Proj2Advisors where `id` = '$oldAdvisorID'";
					$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
					$row2 = mysql_fetch_row($rs2);
					$oldAdvisorName = $row2[1] . " " . $row2[2];
					$oldLocation = $row2[5];
				}
				else
				{
					$oldAdvisorName = "Group";
					$oldLocation = "ITE200";
				}
				//display old appt info
				echo "<h2 style='margin-top: 15px; margin-bottom: 10px;'>Previous Appointment</h2>";
				echo "<label for='info' style='font-weight: normal;'>";
				echo "<b>Advisor</b>: ", $oldAdvisorName, "<br>";
				echo "<b>Appointment</b>: ", date('l, F d, Y g:i A', $oldDatephp), "<br>";
				echo "<b>Location</b>: ", $oldLocation, "</label>";
			}
			
			$currentAdvisorName;
			$currentAdvisorID = $_SESSION["advisor"];
			$currentDatephp = strtotime($_SESSION["appTime"]);
			//if new appt is not group
			if($currentAdvisorID != 0){
				//get new advisor's name and location
				$sql2 = "select * from Proj2Advisors where `id` = '$currentAdvisorID'";
				$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
				$row2 = mysql_fetch_row($rs2);
				$currentAdvisorName = $row2[1] . " " . $row2[2];
				$currentLocation = $row2[5];
			}
			else
			{
				$currentAdvisorName = "Group";
				$currentLocation = "ITE200";
			}
			
			//display new appt info
			echo "<h2 style='margin-top: 15px; margin-bottom: 10px;'>New Appointment</h2>";
			echo "<label for='newinfo' style='font-weight: normal;'>";
			echo "<b>Advisor</b>: ",$currentAdvisorName,"<br>";
			echo "<b>Appointment</b>: ",date('l, F d, Y g:i A', $currentDatephp), "<br>";
			echo "<b>Location</b>: ", $currentLocation, "</label>";
		?>
        </div>
	    <div class="nextButton">
		<?php
			if($_SESSION["resch"] == true){
				echo "<input type='submit' name='finish' class='button large go' value='Reschedule'>";
			}
			else{
				echo "<input type='submit' name='finish' class='button large go' value='Submit'>";
			}
		?>
			<input style="margin-left: 50px" type="submit" name="finish" class="button large" value="Cancel">
	    </div>
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