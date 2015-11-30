<?php
session_start();
$debug = false;

include('../CommonMethods.php');
$COMMON = new Common($debug);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <div id="header">
	<form action="Logout.php" method="post" name="Logout">
	<div class="logoutButton">
		<input type="submit" name="logout" class="button large logout" value="Logout">
	</div>
	</form>
	<?php
	if ($_SESSION["admin"] == false) {
		$studid = $_SESSION["studID"];
		$sql = "select `FirstName` from Proj2Students where `StudentID` = '$studid'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		echo "<h3 style=\"position: relative; top: -20px;\">Hello, $row[0].</h3>";
		
				
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
	}
	else {

		if(!isset($_SESSION["UserN"])) // someone landed this page by accident
		{
			return;
		}		

		$User = $_SESSION["UserN"];
		$Pass = $_SESSION["PassW"];
		$sql = "SELECT `firstName` FROM `Proj2Advisors` 
			WHERE `Username` = '$User' 
			and `Password` = '$Pass'";

		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		echo "<h3 style=\"position: relative; top: 5px;\">Hello, $row[0].</h3>";
	}
	?>
  </div>
 </html>