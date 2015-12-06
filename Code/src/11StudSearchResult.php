<?php
session_start();
//ini_set('display_errors','1');
//ini_set('display_startup_errors','1');
//error_reporting (E_ALL);

?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Search for Appointment</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
	<div class="container">
	<?php
		include('./header.php');
	?>
	<div class="container main">
	<div id="sectionFullLarge">
		<div class="top">
		<h1>Search Results</h1>
	    <div class="field" style="font-size: 14px">
			<p style="font-size: 14px">Showing results for: </p>
			<?php
				//set up variables
				$row = getInfo($_SESSION["studID"], $_SESSION["admin"], $COMMON); 
		
				$major = $row[5];
				$date = $_POST["date"];
				$times = $_POST["time"];
				$advisor = $_POST["advisor"];
				$results = array();
				
				//if no date specified, use all dates
				if($date == ''){ echo "Date: All"; }
				else{ 
					//otherwise print date specified
					echo "Date: ",$date;
					$date = date('Y-m-d', strtotime($date));
				}
				//if no time specified, use all times
				echo "<br>";
				if(empty($times)){ echo "Time: All"; }
				//otherwise list times selected
				else{
					$i = 0;
					echo "Time: ";

					foreach($times as $t){
						echo ++$i, ") ", date('g:i A', strtotime($t)), " ";
					}
				}
				echo "<br>";
				//if no advisor, use all advisors
				if($advisor == ''){ echo "Advisor: All appointments"; }
				//if individual only specified, only use individual appts
				elseif($advisor == 'I'){ echo "Advisor: All individual appointments"; }
				//if group specified, only use group appts
				elseif($advisor == '0'){ echo "Advisor: All group appointments"; }
				//otherwise use specified advisor
				else{
					$sql = "select * from Proj2Advisors where `id` = '$advisor'";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					while($row = mysql_fetch_row($rs)){
						echo "Advisor: ", $row[1], " ", $row[2];
					}
				}
				?>
				<p style="font-size: 14px; font-weight: bold;">Showing open appointments only</p>
				<br><br><label>
				<?php
				//if no times selected, get all times from selected advisor
				if(empty($times)){
					//get all individual appts
					if($advisor == 'I'){
							//query: get all open individual appointments with the given date and major, sorted by Time
						$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` != 0 and `EnrolledNum` = 0 and `Major` like '%".$major."%' order by `Time` ASC Limit 30";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					}
					//get all appts from selected advisor
					else{
						$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `AdvisorID` like '%$advisor%' and `EnrolledNum` = 0 and `Major` like '%".$major."%' order by `Time` ASC Limit 30";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					}
					$row = mysql_fetch_row($rs);
					$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					//if an appt was found
					if($row){
						//get each row
						while($row = mysql_fetch_row($rsA)){
							//get advisor name
							if($row[2] == 0){
								$advName = "Group";
							}
							else{ $advName = getAdvisorName($row); }
							
							//get majors and convert from abbreviations to full names
							$majors = $row[3];
							$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
							$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
							$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
							$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
							$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);

							//create string for table
							$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
									"<td>". $advName."</td>". 
									"<td>". $majors. "</td></tr>";
									
							//insert into array
							array_push($results, $found);
						}
					}
				}
				//repeat above for specified times
				else{
					foreach($times as $t){
						//get all individual appts
						if($advisor == 'I'){
							//query: get all open individual appointments with the given time, date, and major, sorted by Time
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `Time` like '%$t%' and `AdvisorID` != 0 and `EnrolledNum` = 0 and `Major` like '%".$major."%' order by `Time` ASC Limit 30";
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
						}
						//get all appts for specified advisor
						else{ 
							//query: get all open group appointments with the given time, date, and major, sorted by Time
							$sql = "select * from Proj2Appointments where `Time` like '%$date%' and `Time` > '".date('Y-m-d H:i:s')."' and `Time` like '%$t%' and `AdvisorID` like '%$advisor%' and `EnrolledNum` = 0 and `Major` like '%".$major."%' order by `Time` ASC Limit 30";
							$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
						}
						$row = mysql_fetch_row($rs);
						$rsA = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
						if($row){
							//get each row
							while($row = mysql_fetch_row($rsA)){
								//if advisorID=0, it's a group appt
								if($row[2] == 0){
									$advName = "Group";
								}
								else{ $advName = getAdvisorName($row); }
								//convert abbreviations to full major names
								$majors = $row[3];
								$majors = str_replace("CMPE", "Computer Engineering<br>", $majors);
								$majors =  str_replace("CENG", "Chemical Engineering<br>", $majors);
								$majors =  str_replace("MENG", "Mechanical Engineering<br>", $majors);
								$majors =  str_replace("CMSC", "Computer Science<br>", $majors);
								$majors =  str_replace("ENGR", "Engineering Undecided<br>", $majors);

								//create an entry for the array of results
								$found = 	"<tr><td>". date('l, F d, Y g:i A', strtotime($row[1]))."</td>".
										"<td>". $advName."</td>". 
										"<td>". $majors. "</td></tr>";
										array_push($results, $found);
							}
						}
					}
				}
				//if no appts were found, print statement
				if(empty($results)){
					echo "No results found.<br><br>";
				}
				//otherwise print table with all appts found
				else{					
					echo("<table border='1' width=896px><th colspan='3'>Appointments Available</th>\n");
					echo("<tr><td>Time:</td><td>Advisor</td><td>Major</td></tr>\n");

					foreach($results as $r){ echo($r."\n"); }

					echo("</table>");
				}
			?>
			</label>
        </div>
		<p style="font-size: 12px">If the Major category is followed by a blank, then it is open for all majors.</p>
		</div>
		<div class="bottom">		
		<form action="02StudHome.php" method="link">
	    <div class="nextButton">
			<input type="submit" name="done" class="button large go" value="Done">
	    </div>
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

<?php


// More code reduction by Lupoli - 9/1/15
// just getting the advisor's name
function getAdvisorName($row)
{
	global $debug; global $COMMON;
	$sql2 = "select * from Proj2Advisors where `id` = '$row[2]'";
	$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	$row2 = mysql_fetch_row($rs2);
	return $row2[1] ." ". $row2[2];
}

?>