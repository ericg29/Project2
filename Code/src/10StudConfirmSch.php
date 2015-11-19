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
	<div id="login">
      <div id="form">
        <div class="top">
		<h1>Confirm Appointment</h1>
	    <div class="field">
		<form action = "StudProcessSch.php" method = "post" name = "SelectTime">
	    <?php
			$debug = false;
			include('../CommonMethods.php');
			$COMMON = new Common($debug);
			
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
				echo "<h2>Previous Appointment</h2>";
				echo "<label for='info'>";
				echo "Advisor: ", $oldAdvisorName, "<br>";
				echo "Appointment: ", date('l, F d, Y g:i A', $oldDatephp), "<br>";
				echo "Location: ", $oldLocation, "</label>";
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
			echo "<h2>Current Appointment</h2>";
			echo "<label for='newinfo'>";
			echo "Advisor: ",$currentAdvisorName,"<br>";
			echo "Appointment: ",date('l, F d, Y g:i A', $currentDatephp), "<br>";
			echo "Location: ", $currentLocation, "</label>";
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
  </body>
</html>