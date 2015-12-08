<?php
session_start();
$_SESSION["admin"] = true;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>UMBC COEIT Engineering and Computer Science Advising Admin Sign In</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
  <div class="container" style="min-height: 300px">
	<div id="header"><div><h3 style="position: relative; top: 5px;">This works best using any browser <u>OTHER</u> than Internet Explorer.</h3></div></div>
	<div class="container main" style="top: 0px; min-height: 300px;">
	<div id="sectionFull" style="min-height: 300px;">
<h1>COEIT Engineering and Computer Science Advising</h1>
		<h2>Admin Sign In</h2><br>
<form action="AdminProcessSignIn.php" method="POST" name="SignIn">        

		<?php
		  if($_GET["UserVal"] == true){
			echo "<h3 style='color:red; float:left;'>Invalid Username/Password combination</h3><br>";
		  }
		?>

	    <div class="field">
	      <label for="UserN">Username</label>
	      <input id="UserN" size="20" maxlength="50" type="text" name="UserN" required autofocus>
	    </div>

	    <div class="field">
	      <label for="PassW">Password</label>
	      <input id="PassW" size="20" maxlength="50" type="password" name="PassW" required>
	    </div>

	    <div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Next">
	    </div>
		<br>
	</form>
	</div>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  
  
  </body>
  
</html>
        