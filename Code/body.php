<?php
	session_start();
	$debug = false;

	$studExist = false;
	$adminCancel = false;
	$noApp = false;
	$studid = $_SESSION["studID"];

	$sql = "select * from Proj2Students where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);

	if (!empty($row)){
		$studExist = true;
		if($row[6] == 'C'){
			$adminCancel = true;
		}
		if($row[6] == 'N'){
			$noApp = true;
		}
	}
?>
		
<html lang="en">
  <head>
    <meta charset="UTF-8" />
	<link rel='stylesheet' type='text/css' href='css/standard.css'/>
  </head>		
	<div id="nav">
		<form action="StudProcessHome.php" method="post" name="Home">
		<?php
			if ($_SESSION["studExist"] == false || $adminCancel == true || $noApp == true){
				
				echo "<button type='submit' name='selection' class='button main selection' value='Signup'>Signup for an appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Next'>Find the next available appointment</button><br>";
			}
			else{
				echo "<button type='submit' name='selection' class='button main selection' value='View'>View my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Reschedule'>Reschedule my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Cancel'>Cancel my appointment</button><br>";
			}
			echo "<button type='submit' name='selection' class='button main selection' value='Search'>Search for appointment</button><br>";
			echo "<button type='submit' name='selection' class='button main selection' value='Edit'>Edit student information</button><br>";
		?>
		</form>
	</div>
 </html>