<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Group Appointment</title>
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
        <?php
		if ($_POST["groupApp"]) {
			$group = $_POST["groupApp"];
		}
		else {
          $group = $_GET["groupApp"];			
		}
		  $delete = $_GET["delete"];
          parse_str($group);

		  //if the appt was deleted
          if($delete == true){
            echo("<h1>Removed Appointment</h1><br>");
			echo("<div class=\"appInfo\">");
			
			//get the IDs of the students enrolled in the cancelled appt
            $sql = "SELECT `EnrolledID` FROM `Proj2Appointments` WHERE `Time` = '$row[1]'
              AND `AdvisorID` = '0' 
              AND `Major` = '$row[2]' 
              AND `EnrolledNum` = '$row[3]'
              AND `Max` = '$row[4]'";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");

           $stds = mysql_fetch_row($rs);
	    $stds = trim($stds[0]); // had some side white spaces sometimes
	    $stds = split(" ", $stds);

            if($debug) { var_dump("\n<BR>EMAILS ARE: $stds \n<BR>"); }
		// foreach($stds as $element) { echo("->".$element."\n"); }

        if($row[3] > 0)
	    {

			//update the student database to show that their appts were cancelled
              foreach($stds as $element){
                $element = trim($element);
				$sql = "UPDATE `Proj2Students` SET `Status`='C' WHERE `StudentID` = '$element'";
                $rs = $COMMON->executeQuery($sql, "Advising Appointments");
				
				//get students' email addresses
                $sql = "SELECT `Email` FROM `Proj2Students` WHERE `StudentID` = '$element'";
                $rs = $COMMON->executeQuery($sql, "Advising Appointments");
                $ros = mysql_fetch_row($rs);
				
				//send an email notifying students that their appt was cancelled
                $eml = $ros[0];
                $message = "The following group appointment has been deleted by the adminstration of your advisor: " . "\r\n" .
                "Time: $row[1]" . "\r\n" . 
                "To schedule for a new appointment, please log back into the UMBC COEIT Engineering and Computer Science Advising webpage." . "\r\n" .
		"http://coeadvising.umbc.edu  -> COEIT Advising Scheduling \r\n Reminder, this is only accessible on campus."; 
                mail($eml, "Your COE Advising Appointment Has Been Deleted", $message);
              }
            }
			//delete the appt
            $sql = "DELETE FROM `Proj2Appointments` WHERE `Time` = '$row[1]' 
              AND `AdvisorID` = '0' 
              AND `Major` = '$row[2]' 
              AND `EnrolledNum` = '$row[3]'
              AND `Max` = '$row[4]'";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");

            echo("<b>Time</b>: ". date('l, F d, Y g:i A', strtotime($row[1])). "<br>");
            echo("<b>Majors included</b>: ");

            if($row[2]){
				//replace abbreviations with full major names
				$majors = $row[2];
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
            else{ echo("Available to all majors<br>"); }

            echo("<b>Number of students enrolled</b>: $row[3]<br>");
            echo("<b>Student limit</b>: $row[4]");
			echo("</div><br></div>");
            echo("<form method=\"link\" action=\"AdminUI.php\">");
            echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Return to Home\">");
            echo("</form>");
            echo("<div class=\"bottom\">");
            if($stds[0]){
              echo "<p style='color:red'>Students have been notified of the cancellation.</p>";
            }
			echo("</div>");
          }
		  //if the appt was only changed, not deleted
          else{
            echo("<h1>Changed Appointment</h1><br>");
			//display the old appt
			echo("<h2>Previous Appointment:</h2>");
			echo("<div class=\"appInfo\">");
            echo("<b>Time</b>: ". date('l, F d, Y g:i A', strtotime($row[1])). "<br>");
            echo("<b>Majors included</b>: ");
            if($row[2]){ 
				//replace abbreviations with full major names
				$majors = $row[2];
				$majors = str_replace("CMPE", "Computer Engineering", $majors);
				$majors =  str_replace("CENG", "Chemical Engineering", $majors);
				$majors =  str_replace("MENG", "Mechanical Engineering", $majors);
				$majors =  str_replace("CMSC", "Computer Science", $majors);
				$majors =  str_replace("ENGR", "Engineering Undecided", $majors);
			echo("$majors<br>"); 
			}
            else{
              echo("Available to all majors<br>"); 
            }
            echo("<b>Number of students enrolled</b>: $row[3]<br>");
            echo("<b>Student limit</b>: $row[4]");
			echo("</div>");
			//display the new appt
            echo("<h2>Updated Appointment:</h2>");
            $limit = $_POST["stepper"];
			echo("<div class=\"appInfo\">");
            echo("<b>Time: </b>". date('l, F d, Y g:i A', strtotime($row[1])). "<br>");
            echo("<b>Majors included: </b>");
            if($row[2]){ 
				//replace abbreviations with full major names
				$majors = $row[2];
				$majors = str_replace("CMPE", "Computer Engineering", $majors);
				$majors =  str_replace("CENG", "Chemical Engineering", $majors);
				$majors =  str_replace("MENG", "Mechanical Engineering", $majors);
				$majors =  str_replace("CMSC", "Computer Science", $majors);
				$majors =  str_replace("ENGR", "Engineering Undecided", $majors);
			echo("$majors<br>"); 
			}
            else{
              echo("Available to all majors<br>"); 
            }
            echo("<b>Number of students enrolled</b>: $row[3] <br>");
            echo("<b>Student limit</b>: $limit");

			//update the max limit in the selected appointment
            $sql = "UPDATE `Proj2Appointments` SET `Max`='$limit' WHERE `Time` = '$row[1]' 
                    AND `AdvisorID` = '$0' AND `Major` = '$row[2]' 
                    AND `EnrolledNum` = '$row[3]' AND `Max` = '$row[4]'";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments"); 
			echo("</div><br></div>");
            echo("<form method=\"link\" action=\"AdminUI.php\">");
            echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Return to Home\">");
            echo("</form>");
          }
        ?>
	 
	</div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  </body>
  
</html>