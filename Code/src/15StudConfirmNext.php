<?php
session_start();
$_SESSION["type"] = $_POST["type"];
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Find Next Available Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>  </head>
  <body>
	<div id="login">
      <div id="form">
        <div class="top">
		<h1>Find Next Available Appointment</h1>
	    <div class="field">
		<form action = "StudProcessSch.php" method = "post" name = "SelectTime">
	    <?php
			$debug = false;
			include('../CommonMethods.php');
			$COMMON = new Common($debug);
			
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
				echo "<label for='newinfo'>";
				echo "Advisor: ",$advisorName,"<br>";
				echo "Appointment: ",date('l, F d, Y g:i A', $timephp), "<br>";
				echo "Location: ", $location, "</label>";
			
				//print submit button
				echo "</div>";
				echo "<div class=\"nextButton\">";
				echo "<input type='submit' name='finish' class='button large go' value='Submit' style='margin-right: 50px'>";
			}
			//if no appt available
			else
			{
				echo "<p style=\"color:red\">No more appointments are available.</p>";
				$_SESSION["advisor"] = "unavailable";
			}
		?>
			<input type="submit" name="finish" class="button large" value="Cancel">
	    </div>
		</form>
		</div>
  </body>
</html>