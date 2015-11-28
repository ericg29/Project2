<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Student or Admin</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
	<div class="container" style="min-height: 270px">
	<div id="header"></div>
	<div class="container main" style="top: 0px; min-height: 270px;">
	<div id="sectionFull" style="text-align: center;">
	<h1>Welcome to COEIT Engineering and Computer Science Advising</h1>
	<br>
	<span>
		<button onclick="location.href = '01StudSignIn.php'" class="button large go" style="margin-right: 50px">Sign in as a Student</button>
		<button onclick="location.href = 'AdminSignIn.php'" class="button large go" >Sign in as an Admin</button>
	</span>
	<br>
	<br>
    </div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  </body>
  
</html>


