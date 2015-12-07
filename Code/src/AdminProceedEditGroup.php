<?php
session_start();
$delete = false;
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
          <h1>Edit Group Appointment</h1>
		  <div class="appInfo">
          <?php

            $group = $_GET["groupApp"];
            parse_str($group);

			//set up form to edit appt
            echo("<form action=\"AdminConfirmEditGroup.php\" method=\"post\" name=\"Edit\">");
            echo("Time: ". date('l, F d, Y g:i A', strtotime($row[1])). "<br>");
            echo("Majors included: ");
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
            else{
              echo("Available to all majors<br>"); 
            }
            echo("Number of students enrolled: $row[3] <br>");
			//input for student limit
            echo("Student limit: ");
            echo("<input type=\"number\" id=\"stepper\" name=\"stepper\" min=\"$row[3]\" max=\"10\" value=\"$row[4]\" />");

            echo("<br><br>");


			if($row[3] > 0){
              echo "<p style='color:red'>Note: There are currently $row[3] students enrolled in this appointment. <br>
                    The student limit cannot be changed to be under this amount.</p>";
            }
            echo("</div>");
			echo("</div>");
            echo("<div class=\"nextButton\">");
			echo("<input type=\"hidden\" name=\"groupApp\" value=\"$group\"> ");
			echo("<input type=\"hidden\" name=\"delete\" value=\"$delete\"> ");
            echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Submit\">");
            echo("</div>");
          ?>
			</form>
		</div>
		</div>
		<?php
			include('./footer.php');
		?>
	</div>
  </body>
  
</html>

        