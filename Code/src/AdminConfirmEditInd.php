<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Individual Appointment</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>  
  </head>
  <body>
    <div class="container">
		<?php
			include('./header.php');
		?>
		<div class="container admin">
		<div id="nav">
			<form action="AdminProcessUI.php" method="post" name="UI">
		  
				<input type="submit" name="next" class="button main selection" value="Schedule appointments"><br>
				<input type="submit" name="next" class="button main selection" value="Print schedule for a day"><br>
				<div class="button selected">Edit appointments</div><br>
				<input type="submit" name="next" class="button main selection" value="Search for an appointment"><br>
				<input type="submit" name="next" class="button main selection" value="Create new Admin Account"><br>
			
			</form>
		</div>
		<div id="section">
        <div class="top">
        <h1>Removed Appointment</h1><br>
		<div class="appInfo">
          <?php
            $ind = $_POST["IndApp"];
            parse_str($ind);

			//get advisor ID from appt
            $sql = "SELECT `id` FROM `Proj2Advisors` WHERE `FirstName` = '$row[2]' AND `LastName` = '$row[3]'";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");
            $rod = mysql_fetch_row($rs);
            $adv = $rod[0];

			//get name and email of student from appt
            if($row[5]){
              $sql = "SELECT `FirstName`, `LastName`, `Email` FROM `Proj2Students` WHERE `StudentID` = '$row[5]'";
              $rs = $COMMON->executeQuery($sql, "Advising Appointments");
              $ros = mysql_fetch_row($rs);
              $std = $ros[0] . " " . $ros[1];
              $eml = $ros[2];
            }

			//delete the appt
            $sql = "DELETE FROM `Proj2Appointments` WHERE `Time` = '$row[1]' AND `AdvisorID` = '$adv' AND `Major` = '$row[4]' AND `EnrolledID` = '$row[5]'";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");

			//print the appt info
            echo("<b>Time</b>: ". date('l, F d, Y g:i A', strtotime($row[1])). "<br>");
            echo("<b>Advisor</b>: $row[2] $row[3]<br>");
            echo("<b>Majors included</b>: ");
            if($row[4]){
				//replace abbreviations with full major names
				$majors = $row[4];
 				if (trim($majors) == 'CMPE CMSC MENG CENG ENGR')
				{
					echo("All<br>"); 
				}
				else
				{
					$majors = str_replace("CMPE", "<label style='margin-left:30px;'>Computer Engineering</label><br>", $majors);
					$majors =  str_replace("CENG", "<label style='margin-left:30px;'>Chemical Engineering</label><br>", $majors);
					$majors =  str_replace("MENG", "<label style='margin-left:30px;'>Mechanical Engineering</label><br>", $majors);
					$majors =  str_replace("CMSC", "<label style='margin-left:30px;'>Computer Science</label><br>", $majors);
					$majors =  str_replace("ENGR", "<label style='margin-left:30px;'>Engineering Undecided</label><br>", $majors);
					echo("<br>$majors"); 
				}
            }
            else{
              echo("Available to all majors<br>"); 
            }
            echo("<b>Enrolled</b>: ");
            if($row[5]){
              echo("$std</b>");
			  //update the student in the database to show that the appt was cancelled
              $sql = "UPDATE `Proj2Students` SET `Status`='C' WHERE `StudentID` = '$row[5]'";
              $rs = $COMMON->executeQuery($sql, "Advising Appointments");
			  
			  //send the student an email to notify them that the appt was cancelled
              $message = "The following appointment has been deleted by the adminstration of your advisor: " . "\r\n" .
                "Time: $row[1]" . "\r\n" . 
                "Advisor: $row[2] $row[3]" . "\r\n" . 
                "Student: $std" . "\r\n" . 
                "To schedule for a new appointment, please log back into the UMBC COEIT Engineering and Computer Science Advising webpage." . "\r\n" .
		"http://coeadvising.umbc.edu  -> COEIT Advising Scheduling \r\n Reminder, this is only accessible on campus."; 
              mail($eml, "Your Advising Appointment Has Been Deleted", $message); 
            }
            else{
              echo("Empty");
            }
			?>
			</div>
			<br>
		<?php
		if($std){
              echo "<p style='color:red;font-size:14px;'>$std has been notified of the cancellation.</p>";
        }
		?>
		<br>	
		</div>   
		<div class="bottom">
		<form method="link" action="AdminUI.php">
			<input type="submit" name="home" class="button large go" value="Return to Home">
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


