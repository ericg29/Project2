<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create New Admin</title>
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
				<input type="submit" name="next" class="button main selection" value="Search for an appointment"><br>
				<input type="submit" name="next" class="button main selection" value="Create new Admin Account"><br>
			
			</form>
		</div>
		<div id="section">
			<div class="top">
				<h2>New Advisor has been created:</h2>
				<br>
				<div style='text-align: center;'>
				<?php
					$row = getInfo($_SESSION["UserN"], $_SESSION["admin"], $COMMON);
					$first = $row[1];
					$last = $row[2];
					$user = $_SESSION["UserN"];
					$pass = $_SESSION["PassW"];
					$room = $row[5];
					$meetingLoc = $row[6];
			
					//query: Get advisor with given username, name, and location
					$sql = "SELECT * FROM `Proj2Advisors` WHERE `Username` = '$user' AND `FirstName` = '$first' AND  `LastName` = '$last' AND  `room` = '$room'";
					$rs = $COMMON->executeQuery($sql, "Advising Appointments");
					$row = mysql_fetch_row($rs);
					//check if the user exists
					if($row){
						echo("<p style='font-size: 16px;'>Advisor $first $last already exists</p>");
					}
					else{
						//query: insert new advisor with given info
						$sql = "INSERT INTO `Proj2Advisors`(`FirstName`, `LastName`, `Username`, `Password`, `Room`, `MeetingLocation`) 
						VALUES ('$first', '$last', '$user', '$pass', '$room','$meetingLoc')";
						echo ("<p style='font-size: 16px;'>$first $last<p>");
						$rs = $COMMON->executeQuery($sql, "Advising Appointments");
					}
				?>
				</div>
				<br>
			</div>
			<form method="link" action="AdminUI.php">
				<input type="submit" name="next" class="button large go" value="Return to Home">
			</form>
		</div>
		</div>
		<?php
			include('./footer.php');
		?>
	</div>
  </body>
  
</html>