<?php
session_start();
$debug = false;

?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Cancel Appointment</title>
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
				echo "<button type='submit' name='selection' class='button main selection' value='Next'>Find the next available appointment</button><br>";
			}
			else{
				echo "<button type='submit' name='selection' class='button main selection' value='View'>View my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Reschedule'>Reschedule my appointment</button><br>";
				echo "<div class='button selected' >Cancel my appointment</div><br>";
			}
			echo "<button type='submit' name='selection' class='button main selection' value='Search'>Search for appointment</button><br>";
			echo "<button type='submit' name='selection' class='button main selection' value='Edit'>Edit student information</button><br>";
		?>
		</form>
	</div>
	<div id="section">
        <div class="top" style="text-align: center;">
		<h1>Cancel Appointment</h1>
	    <div class="field">
	    <?php
			//get student ID
			$studid = $_SESSION["studID"];
			
			//get appt that matches ID
			$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$row = mysql_fetch_row($rs);
			$oldAdvisorID = $row[2];
			$oldDatephp = strtotime($row[1]);				
				
			//if not group appt, get advisor's name
			if($oldAdvisorID != 0){
				$sql2 = "select * from Proj2Advisors where `id` = '$oldAdvisorID'";
				$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
				$row2 = mysql_fetch_row($rs2);					
				$oldAdvisorName = $row2[1] . " " . $row2[2];
				$location = $row2[5];
			}
			//otherwise name is "group"
			else
			{
				$advisorName = "Group";
				$location = "ITE200";
			}
			
			//display appt info
			echo "<h2>Current Appointment</h2>";
			echo "<div><label class='appInfo' for='info' style='font-weight: normal;'>";
			echo "<b>Advisor</b>: ", $oldAdvisorName, "<br>";
			echo "<b>Appointment</b>: ", date('l, F d, Y g:i A', $oldDatephp), "<br>";
			echo "<b>Location</b>: ", $location, "</label></div>";
		?>		
		<div class="buttonContainer">
			<form action = "StudProcessCancel.php" method = "post" name = "Cancel">
				<input type="submit" name="cancel" class="button large go" value="Cancel" style="width: 90px; margin-right: 15px;">
				<input type="submit" name="cancel" class="button large" value="Keep" style="width: 90px; margin-left: 15px;">
			</form>
		</div>
        </div>
		</div>
		<div class="bottom">
			<p>Click "Cancel" to cancel appointment. Click "Keep" to keep appointment.</p>
		</div>
	</div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  </body>
</html>