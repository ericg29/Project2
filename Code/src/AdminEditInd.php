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
	<div id="sectionFullLarge">
	<div class="top">
          <h2>Select which appointment you would like to delete: </h2>
		  <div class="field">
		  
          <?php

			//query: get all indiviual appointments after the current time/date
            $sql = "SELECT * FROM `Proj2Appointments` WHERE `AdvisorID` != '0' and `Time` > '".date('Y-m-d H:i:s')."' ORDER BY `Time`";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");
            $row = mysql_fetch_array($rs, MYSQL_NUM); 
			//first item in row
            if($row){
              echo("<form action=\"AdminConfirmEditInd.php\" method=\"post\" name=\"Confirm\">");
              

			echo("<table border='1px' width=896px>\n<tr>");
			echo("<tr><td width='50%'>Time</td><td width=25%>Majors</td><td>Enrolled</td></tr>\n");

			//query: get the advisor's name
			$secsql = "SELECT `FirstName`, `LastName` FROM `Proj2Advisors` WHERE `id` = '$row[2]'";
			$secrs = $COMMON->executeQuery($secsql, "Advising Appointments");
			$secrow = mysql_fetch_row($secrs);

			if($row[4]){
			  //query: get student's name
			  $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[4]'";
			  $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
			  $trdrow = mysql_fetch_row($trdrs);
			}

			//display radio button for this appointment
			echo("<tr><td><label style=\"font-weight:normal\" for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"IndApp\" 
			  required value=\"row[]=$row[1]&row[]=$secrow[0]&row[]=$secrow[1]&row[]=$row[3]&row[]=$row[4]\">");
			echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
              
			  //display the majors for this appointment
			  if($row[3]){
				//replace abbreviations with full major names
				$majors = $row[3];
				$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
				$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
				$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
				$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
				$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);
                echo("<td><label style=\"font-weight:normal\">$majors</label></td>"); 
              }
              else{
                  echo("<td><label style=\"font-weight:normal\">Available to all majors</label></td>"); 
              }
              
			  //display student ID (if it exists)
              if($row[4]){
                echo("<td><label style=\"font-weight:normal\">$trdrow[0] $trdrow[1]</label></td>");
              }
              else{
                echo("<td><label style=\"font-weight:normal\">Empty</label></td>");
              }
			  echo("</label style=\"font-weight:normal\"></tr>\n");

              
			  //rest of items in row
              while ($row = mysql_fetch_array($rs, MYSQL_NUM)) {
				//query: get advisor's name
                $secsql = "SELECT `FirstName`, `LastName` FROM `Proj2Advisors` WHERE `id` = '$row[2]'";
                $secrs = $COMMON->executeQuery($secsql, "Advising Appointments");
                $secrow = mysql_fetch_row($secrs);

                if($row[4]){
				  //query: get student's name
                  $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[4]'";
                  $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
                  $trdrow = mysql_fetch_row($trdrs);
                }

				//display radio button for this appointment
                echo("<tr><td><label style=\"font-weight:normal\" for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"IndApp\" 
                  required value=\"row[]=$row[1]&row[]=$secrow[0]&row[]=$secrow[1]&row[]=$row[3]&row[]=$row[4]\">");
                echo(date('l, F d, Y g:i A', strtotime($row[1])). "</label></td>");
				
				//display majors for this appointment
                if($row[3]){
					//replace abbreviations with full major names
					$majors = $row[3];
					$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
					$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
					$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
					$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
					$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);
					echo("<td><label style=\"font-weight:normal\">$majors</label></td>"); 
                }
                else{
                  echo("<td></label style=\"font-weight:normal\">Available to all majors</label></td>"); 
                }

                //display student ID (if it exists)
                if($row[4]){	
                  echo("<td><label style=\"font-weight:normal\">$trdrow[0] $trdrow[1]</label</td>");
                }
                else{
                  echo("<td><label style=\"font-weight:normal\">Empty</label></td>");
                }
				echo("</tr>\n");
		
                
				
              }
              echo("</table>");
			  echo("<label style='color:red; margin-top:10px;'>Please note that individual appointments can only be removed from schedule.</label></br>");
              echo("<div class=\"nextButton\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Delete Appointment\">");
			  echo("</form>");
              echo("</div>");
              echo("</div>");
              echo("</div>");
			  echo("<form method=\"link\" action=\"AdminUI.php\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large\" value=\"Cancel\">");
              echo("</form>");
            }
            else{
              echo("<br><b>There are currently no individual appointments scheduled at the current moment.</b>");
              echo("<br><br></div></div>");
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