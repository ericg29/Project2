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
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>New Advisor has been created:</h2>

		<?php
			$first = $_SESSION["AdvF"];
			$last = $_SESSION["AdvL"];
			$user = $_SESSION["AdvUN"];
			$pass = $_SESSION["AdvPW"];
			$room = $_SESSION["AdvRN"];

			include('../CommonMethods.php');
			$debug = false;
			$Common = new Common($debug);
	
	  //query: Get advisor with given username, name, and location
      $sql = "SELECT * FROM `Proj2Advisors` WHERE `Username` = '$user' AND `FirstName` = '$first' AND  `LastName` = '$last' AND  `room` = '$room'";
      $rs = $Common->executeQuery($sql, "Advising Appointments");
      $row = mysql_fetch_row($rs);
	  //check if the user exists
      if($row){
        echo("<h3>Advisor $first $last already exists</h3>");
      }
      else{
			//query: insert new advisor with given info
  			$sql = "INSERT INTO `Proj2Advisors`(`FirstName`, `LastName`, `Username`, `Password`, `Room`) 
  			VALUES ('$first', '$last', '$user', '$pass', '$room')";
        echo ("<h3>$first $last<h3>");
        $rs = $Common->executeQuery($sql, "Advising Appointments");
      }
		?>
		<form method="link" action="AdminUI.php">
			<input type="submit" name="next" class="button large go" value="Return to Home">
		</form>
	</div>
	</div>
	</div>
	</form>
  </body>
  
</html>
