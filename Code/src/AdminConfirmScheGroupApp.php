<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Appointments Created</title>
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
		  
				<div class="button selected">Schedule appointments</div><br>
				<input type="submit" name="next" class="button main selection" value="Print schedule for a day"><br>
				<input type="submit" name="next" class="button main selection" value="Edit appointments"><br>
				<input type="submit" name="next" class="button main selection" value="Search for an appointment"><br>
				<input type="submit" name="next" class="button main selection" value="Create new Admin Account"><br>
			
			</form>
		</div>
		<div id="section">
        <div class="top">
          <h2>Appointments Created</h2><br>
          <?php
            $date = $_POST["Date"];
            $times = $_POST["time"];
            $majors = $_POST["major"];
            $repeatDays = $_POST["repeat"];
            $repeatWeek = $_POST["stepper"];
            $studentLimit = $_POST["stepper1"];
          
          //one week with given start date (Ex. Thur - Wed) ['Thursday']=>[########]
          $d0 = $date;
          $d1 = '+1 day ' . $date;
          $d2 = '+2 day ' . $date;
          $d3 = '+3 day ' . $date;
          $d4 = '+4 day ' . $date;
          $d5 = '+5 day ' . $date;
          $d6 = '+6 day ' . $date;
          $oneweek = array(date('l', strtotime($d0)) => strtotime($d0),
                  date('l', strtotime($d1)) => strtotime($d1),
                  date('l', strtotime($d2)) => strtotime($d2),
                  date('l', strtotime($d3)) => strtotime($d3),
                  date('l', strtotime($d4)) => strtotime($d4),
                  date('l', strtotime($d5)) => strtotime($d5),
                  date('l', strtotime($d6)) => strtotime($d6)); 
          
          //initialize the first wk
          $dates = array();
          array_push($dates, date('Y-m-d',strtotime($date)));
          if(!empty($repeatDays)){
            foreach($repeatDays as $day){
              if($day != date("l", strtotime($date))){
                array_push($dates, date('Y-m-d',$oneweek[$day]));
              }
            }
          }
          //repeat weeks based on initial wk
          $countDates = count($dates);
          for($i=0; $i < $repeatWeek; $i++){
            for($j=0; $j < $countDates; $j++){
              $newDateStr = "+1 week " . $dates[$j + ($i * $countDates)];
              $newDate = date('Y-m-d',strtotime($newDateStr));
              array_push($dates, $newDate);
            }
          }
          
          //pair dates and times to make datetime things YYYY-MM-DD hh:mm:ss
          $datetimes = array();
          foreach($dates as $aDate){
            foreach($times as $time){
              $newDatetime = $aDate . " " . $time;
              array_push($datetimes, $newDatetime);
            }
          }
          
			//major stuff
			$majorDB = "";
			$majorPrint = "";
			if(!empty($majors)){
					foreach($majors as $m){
						$majorDB .= $m . " ";
						$majorPrint .= $m . " ";
					}
				if (trim($majorPrint) == 'CMPE CMSC MENG CENG ENGR')
				{
					$majorPrint = "All<br>";
				}
				else{
					$majorPrint = "<br>".$majorPrint;
					$majorPrint = str_replace("CMPE", "<label style='margin-left:30px;'>Computer Engineering</label><br>", $majorPrint);
					$majorPrint =  str_replace("CENG", "<label style='margin-left:30px;'>Chemical Engineering</label><br>", $majorPrint);
					$majorPrint =  str_replace("MENG", "<label style='margin-left:30px;'>Mechanical Engineering</label><br>", $majorPrint);
					$majorPrint =  str_replace("CMSC", "<label style='margin-left:30px;'>Computer Science</label><br>", $majorPrint);
					$majorPrint =  str_replace("ENGR", "<label style='margin-left:30px;'>Engineering Undecided</label><br>", $majorPrint);
				}
			}
          
          //get advisor id
          $User = $_SESSION["UserN"];
          $Pass = $_SESSION["PassW"];
          $sql = "select `id` from `Proj2Advisors` where `Username` = '$User' and `Password` = '$Pass'";
          $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
          $row = mysql_fetch_row($rs);
          $id = $row[0];
          
          //make sure app doesn't exist
          //insert new app to DB
          //print app
          foreach($datetimes as $dt){
            $sql = "SELECT * from `Proj2Appointments` where `Time` = '$dt' and `AdvisorID` = '0'";
            $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            $row = mysql_fetch_row($rs);
			echo("<div class=\"appInfo\">");
			echo("<b>Date</b>: ");
            echo date('l, F d, Y g:i A', strtotime($dt)), "<br><b>Majors included</b>: ", $majorPrint;
            echo("<b>Number of seats</b>: $studentLimit");
            if($row){
              echo "<br><span style='color:red'>!!</span>";
            }
            else{
              $sql = "insert into Proj2Appointments (`Time`, `AdvisorID`, `Major`, `Max`) values ('$dt', '0', '$majorDB','$studentLimit')";
              $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
            }
            echo "<br></div>";
          }
        ?>
        <br>
        <p style="font-size: 14px"><span style="color:red">!!</span> indicates that this appointment already exists. A repeat appointment was not made.</p>
		</div>
		<div class="bottom">
			<form method="link" action="AdminUI.php">
				<input type="submit" name="next" class="button large go" value="Return to Home">
			</form>
		</div>
		<br>
		</div>
		</div>
	<?php
		include('./footer.php');
	?>
	</div>  
  </body> 
</html>



