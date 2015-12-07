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
			<div id="sectionFullLarge">
			<div class="top">
			  <h1>Edit Group Appointment</h1>
			  <h2>Select an appointment to change</h2>
			  <div class="field">
			  <?php

				//get all group appts
				$sql = "SELECT * FROM `Proj2Appointments` WHERE `AdvisorID` = '0' ORDER BY `Time`";
				$rs = $COMMON->executeQuery($sql, "Advising Appointments");
				$row = mysql_fetch_array($rs, MYSQL_NUM); 
				//first item in row
				if($row){
				  echo("<form action=\"AdminProcessEditGroup.php\" method=\"post\" name=\"Confirm\">");
		echo("<table border='1px'>\n<tr>");
		echo("<tr><td width=50%>Time</td><td width=25%>Majors</td><td width=12%>Seats Enrolled</td><td width=12%>Total Seats</td></tr>\n");

				  echo("<td><label for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"groupApp\" 
					required value=\"row[]=$row[1]&row[]=$row[3]&row[]=$row[5]&row[]=$row[6]\">");
				  echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
				  if($row[3]){
					//replace abbreviations with full major names
					$majors = $row[3];
					$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
					$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
					$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
					$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
					$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);
					echo("<td><label>".$majors."</label></td>"); 
				  }
				  else{
					echo("<td><label>Available to all majors</label></td>"); 
				  }

				  echo("<td><label>$row[5]</label></td><td>
					   <label>$row[6]</label>");
				
				//rest of row
				  echo("</td></tr>\n");
				  while ($row = mysql_fetch_array($rs, MYSQL_NUM)) {
					echo("<tr><td><label for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"groupApp\" 
					  required value=\"row[]=$row[1]&row[]=$row[3]&row[]=$row[5]&row[]=$row[6]\">");
					echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
					if($row[3]){
						//replace abbreviations with full major names
						$majors = $row[3];
						$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
						$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
						$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
						$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
						$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);
					  echo("<td><label>".$majors."</label></td>"); 
					}
					else{
					  echo("<td><label>Available to all majors</label></td>"); 
					}

					echo("<td><label>$row[5]</label></td><td><label>$row[6]</label>");
					echo("</td></tr>");
					
				  }

			echo("</table>");
				echo("<input type=\"hidden\" name=\"advisor\" value=\"Group\"> ");
				  //print buttons
				  echo("<div class=\"nextButton\">");
				  echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Delete Appointment\">");
				  echo("<input style=\"margin-left: 10px\" type=\"submit\" name=\"next\" class=\"button large go\" value=\"Edit Appointment\">");
				  echo("</div>");
				  echo("</form>");
				  echo("<br></div></div>");
				  echo("<form method=\"link\" action=\"AdminUI.php\">");
				  echo("<input type=\"submit\" name=\"next\" class=\"button large\" value=\"Cancel\">");
				  echo("</form>");
				}
				else{
				  echo("<br><b>There are currently no group appointments scheduled at the current moment.</b>");
				  echo("<br></div></div>");
				  echo("<form method=\"link\" action=\"AdminUI.php\">");
				  echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Return to Home\">");
				  echo("</form>");
				}
			  ?>
		<br>
		</div>
		</div>
		<?php
			include('./footer.php');
		?>
	</div>
  </body>
  
</html>