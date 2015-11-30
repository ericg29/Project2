<?php
session_start();
$debug = false;

include('../CommonMethods.php');
$COMMON = new Common($debug);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Print Schedule</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
	<div id="containerPrint">

			<?php
				//get variables
				$date = $_POST["date"];
				$type = $_POST["type"];

				  $User = $_SESSION["UserN"];

				  //get advisor ID and name
				  $sql = "SELECT `id`, `firstName`, `lastName` FROM `Proj2Advisors` WHERE `Username` = '$User'";
				  $rs = $COMMON->executeQuery($sql, "Advising Appointments");
				  $row = mysql_fetch_row($rs);
				  $id = $row[0];
				  $FirstName = $row[1];
				  $LastName = $row[2];
					
				  //display name and get date
				  echo("<h2>Schedule for $FirstName $LastName<br>$date</h2>");
				  $date = date('Y-m-d', strtotime($date));

				//display the requested appt types
				if($_POST["type"] == 'Both')
				{
					displayGroup($id, $date);
					displayIndividual($id, $date);
				}
				elseif($_POST["type"] == 'Individual') { displayIndividual($id, $date); }
				elseif($_POST["type"] == 'Group') { displayGroup($id, $date); }
				else { echo("Selection invalid"); }

			?>
				<form method="link" action="AdminUI.php">
				<input type="submit" name="next" class="button large go" value="Return to Home">
				<input type="button" name="print" class="button large go" value="Print" onClick="window.print()">
				</form>

	</div>
  </body>
  
</html>









<?php

function displayGroup($id, $date)
{
	global $debug; global $COMMON;

	//query: get values from appointments on the specified date, sorted by time
	$sql = "SELECT `Time`, `Major`, `EnrolledID`, `EnrolledNum`, `Max` FROM `Proj2Appointments` 
	WHERE `Time` LIKE '$date%' AND `AdvisorID` = 0 AND `MAX` > 1 ORDER BY `Time` ";

	// ******************************************************************
	// Why is Advisor ID 0 above?? (and not id)
	// This is so everyone on staff can see it when viewing a schedule
	// Then only one advisor can schedule the group sessions
	// Lupoli - 8/18/15
	// ******************************************************************


   	$rs = $COMMON->executeQuery($sql, "Advising Appointments");
	$matches = mysql_num_rows($rs); // see how many rows were collected by the query
	if($debug) { echo("matches was $matches"); }
	if($matches == 0) { return; }

	echo("<div class='appInfo' style='font-size:16px'>");
	echo("<table width='640px' border='1'><th colspan='4'><h2>Group Appointments</h></th>\n");
	echo("<tr><td width='15%'><b>Time:</td><td width='38%'><b>Majors Included:</b></td><td width='27%'><b>Students enrolled</b></td><td width='10%'><b>Number of seats</b></td></tr>\n");

	//print the table of appointments
	while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		//convert abbreviations to full major names
		$majors = $row[1];
		if ($majors == 'CMPE CMSC MENG CENG ENGR')
		{
			$majors = "All";
		}
		else
		{
			$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
			$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
			$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
			$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
			$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);
		}
		echo("<tr>");
		//print date/time
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");
		//print majors
        echo("<td>".$majors."</td>");
		//print number enrolled
		echo("<td>(".$row[3].")".$row[2]."</td>");
		//print number of seats
		echo("<td>".$row[4]."</td>");
		echo("</tr>\n");
	}
        echo("</table><br><br>\n");
}

function displayIndividual($id, $date)
{
	global $debug; global $COMMON;

		//query: get all appointments with the specified date and advisorid, sorted by time
        $sql = "SELECT `Time`, `Major`, `EnrolledID` FROM `Proj2Appointments` 
        WHERE `Time` LIKE '$date%' AND `AdvisorID` = $id AND `MAX` = 1 ORDER BY `Time`";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
	$matches = mysql_num_rows($rs); // see how many rows were collected by the query
	if($debug) { echo("matches was $matches"); }
	if($matches == 0) { return; }
	
	echo("<div class='appInfo' style='font-size:15px'>");
	echo("<table width='640px' border='1'><th colspan='4'><h2>Individual Appointments</h2></th>\n");
	echo("<tr><td width='15%'><b>Time:</b></td><td width=30%><b>Majors Included:</b></td><td width=25%><b>Student's name</b></td><td width=15%><b>Student ID</b></td></tr>\n");
	
	//print each appt into the table
        while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		//convert abbreviations to full major names
		$majors = $row[1];
		$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
		$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
		$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
		$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
		$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);
		
		echo("<tr>");
		//print date/time
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");
		//print majors
        echo("<td>".$majors."</td>");
	    
		//get student info
		$trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
        $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
		$trdrow = mysql_fetch_row($trdrs);
		//print student name
		echo("<td>".$trdrow[0]." ".$trdrow[1]."</td>");
		//print student ID
		echo("<td>".$row[2]."</td>");
		echo("</tr>");
	}
        echo("</table></div><br><br>");
}
?>
