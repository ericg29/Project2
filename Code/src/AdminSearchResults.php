<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Search Appointments</title>
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
				<input type="submit" name="next" class="button main selection" value="Edit appointments"><br>
				<div class="button selected">Search for an appointment</div><br>
				<input type="submit" name="next" class="button main selection" value="Create new Admin Account"><br>
			
			</form>
		</div>
		<div id="section">
			<div class="top">
			<h1>Search results</h1>
			<div class="field small">
			<p>Showing results for: </p>
			<?php
				$date = $_POST["date"];
				$times = $_POST["time"];
				$advisor = $_POST["advisor"];
				$studID = $_POST["studID"];
				$studLN = $_POST["studLN"];
				$filter = $_POST["filter"];
				$results = array();
				
				//list selected search options
				if($date == ''){ echo "Date: All"; }
				else{ 
					echo "Date: ",$date;
					$date = date('Y-m-d', strtotime($date));
				}
				echo "<br>";
				if(empty($times)){ echo "Time: All"; }
				else{
					$i = 0;
					echo "Time: ";
					foreach($times as $t){
						echo ++$i, ") ", date('g:i A', strtotime($t)), " ";
					}
				}
				echo "<br>";
				if($advisor == ''){ echo "Advisor: All appointments"; }
				elseif($advisor == 'I'){ echo "Advisor: All individual appointments"; }
				elseif($advisor == '0'){ echo "Advisor: All group appointments"; }
				else{
					//get advisor names
					$sql = "select * from Proj2Advisors where `id` = '$advisor'";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					while($row = mysql_fetch_row($rs)){
						echo "Advisor: ", $row[1], " ", $row[2];
					}
				}
				echo "<br>";
				if($studID == '' && $studLN == ''){	echo "Student: All"; }
				else{
					$studLN = strtoupper($studLN);
					$studID = strtoupper($studID);
					//get student's last name and ID
					$sql = "select `LastName`, `StudentID` from Proj2Students where `StudentID` = '$studID' or `LastName` = '$studLN'";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$row = mysql_fetch_row($rs);
					$studLN = $row[0];
					$studID = $row[1];
					echo "Student: ", $studID, " ", $studLN;
				}
				echo "<br>";
				if($filter == ''){ echo "Filter: All appointments"; }
				elseif($filter == 0){ echo "Filter: Open appointments"; }
				elseif($filter == 1){ echo "Filter: Closed appointments"; }
				?>
				<br><br><div class="appInfo">
				<?php
				$sql = "select * from Proj2Appointments where `Time` like '%$date%' and";
				//add the following to the query depending on what conditions are met
				//if all individual
				if($advisor == 'I')	{$sql = $sql."`AdvisorID` != 0 and ";}
				else				{$sql = $sql."`AdvisorID` like '%$advisor%' and ";}
				//if no student specified
				if(!($studID == '' && 
				   $studLN == ''))	{$sql = $sql."`EnrolledID` like '%$studID%' and ";}
				//if closed appts only
				if($filter == 1)	{$sql = $sql."`EnrolledNum` >= 1";}
				else				{$sql = $sql."`EnrolledNum` like '%$filter%'";}
				
				//if no times are specified
				if(empty($times)){
					//sort by time
					$sql = $sql." order by `Time` ASC";
					
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$row = mysql_fetch_row($rs);
					$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					if($row){
						//get each row that meets the criteria
						while($row = mysql_fetch_row($rsA)){
							if($row[2] == 0){
								$advName = "Group";
							}
							else{
								//get advisor name
								$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
								$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
								$row2 = mysql_fetch_row($rs2);
								$advName = $row2[1] ." ". $row2[2];
							}
							//replace abbreviations with full major names
							$majors = $row[3];
							if (trim($majors) == 'CMPE CMSC MENG CENG ENGR')
							{
								$majors = "All";
							}
							else
							{
								$majors = str_replace("CMPE", "Computer Engineering", $majors);
								$majors =  str_replace("CENG", "Chemical Engineering", $majors);
								$majors =  str_replace("MENG", "Mechanical Engineering", $majors);
								$majors =  str_replace("CMSC", "Computer Science", $majors);
								$majors =  str_replace("ENGR", "Engineering Undecided", $majors);
							}
							
							//create entry for array of matching appts
							$found = "<b>Time</b>: ". date('l, F d, Y g:i A', strtotime($row[1])). 
									"<br><b>Advisor</b>: ". $advName. 
									"<br><b>Major</b>: ". $majors. 
									"<br><b>Enrolled Students</b>: ". $row[4]. 
									"<br><b>Number of enrolled student(s)</b>: ". $row[5]. 
									"<br><b>Maximum number of students allowed</b>: ". $row[6]. "<br><br>";
							array_push($results, $found);
						}
					}
				}
				else{
					foreach($times as $t){
						//add specified time to query and sort by time
						$sql2 = $sql." and `Time` like '%$t%' order by `Time` ASC";
						$rs = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
						$row = mysql_fetch_row($rs);
						$rsA = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
						if($row){
							//for each result found
							while($row = mysql_fetch_row($rsA)){
								if($row[2] == 0){
									$advName = "Group";
								}
								else{
									//query: get advisor with given ID
									$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
									$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
									$row2 = mysql_fetch_row($rs2);
									$advName = $row2[1] ." ". $row2[2];
								}
								//replace abbreviations with full major names
								$majors = $row[3];
								if (trim($majors) == 'CMPE CMSC MENG CENG ENGR')
								{
									$majors = "All";
								}
								else
								{
									$majors = str_replace("CMPE", "Computer Engineering", $majors);
									$majors =  str_replace("CENG", "Chemical Engineering", $majors);
									$majors =  str_replace("MENG", "Mechanical Engineering", $majors);
									$majors =  str_replace("CMSC", "Computer Science", $majors);
									$majors =  str_replace("ENGR", "Engineering Undecided", $majors);
								}
								//create entry for array of results
								$found = "<b>Time</b>: ". date('l, F d, Y g:i A', strtotime($row[1])). 
										"<br><b>Advisor</b>: ". $advName. 
										"<br><b>Major</b>: ". $majors. 
										"<br><b>Enrolled Students</b>: ". $row[4]. 
										"<br><b>Number of enrolled student(s)</b>: ". $row[5]. 
										"<br><b>Maximum number of students allowed</b>: ". $row[6]. "<br><br>";
								array_push($results, $found);
							}
						}
					}
				}
				if(empty($results)){
					echo "No results found.<br><br>";
				}
				else{
					foreach($results as $r){
					echo $r;
					}
				}
				?>
				</div>
				<p style="font-size: 14px">If the Major category is followed by a blank, then it is open for all majors.</p>
			</div>
			</div>		
			<form method="link" action="AdminUI.php" name="home">
				<input type="submit" name="next" class="button large go" value="Return to Home">
			</form>
			<br>
		</div>
		</div>
		<?php
			include('./footer.php');
		?>
	</div>
  </body>
  
</html>


        