<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create New Admin</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>

     <script type="text/javascript">
    //   window.onload = function () {
    //       document.getElementById("PassW").onchange = validatePassword;
    //       document.getElementById("ConfP").onchange = validatePassword;
    //   }
    //   function validatePassword(){
    //     var pass2=document.getElementById("ConfP").value;
    //     var pass1=document.getElementById("PassW").value;
    //     if(pass1!=pass2)
    //         document.getElementById("ConfP").setCustomValidity("Passwords Don't Match");
    //     else
    //         document.getElementById("PassW").setCustomValidity('');  
    //     //empty string means no validation error
    //   }
    // </script>
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
				<div class="button selected">Create new Admin Account</div><br>
			
			</form>
		</div>
		<div id="section">
			<div class="top">
				<h2>Create New Advisor Account</h2>
				<?php
				if($_SESSION["PassCon"] == true){
					echo "<h3 style='color:red'>Passwords do not match!!</h3>";
				}
				?>
				<form action="AdminProcessCreateNew.php" method="post" name="Create">
				<div class="field">
						<label for="firstN">First Name</label>
						<input id="firstN" size="20" maxlength="50" type="text" name="firstN" required autofocus>
					</div>

					<div class="field">
						<label for="lastN">Last Name</label>
						<input id="lastN" size="20" maxlength="50" type="text" name="lastN" required>
				</div>	

				<div class="field">
						<label for="UserN">Username</label>
						<input id="UserN" size="20" maxlength="50" type="text" name="UserN" required>
				</div>	 

				<div class="field">
						<label for="PassW">Password</label>
						<input id="PassW" size="20" maxlength="50" type="password" name="PassW" required>
				</div>	

				<div class="field">
						<label for="ConfP">Confirm Password</label>
						<input id="ConfP" size="20" maxlength="50" type="password" name="ConfP" required>
				</div>	
				
				<div class="field">
						<label for="RoomN">Location</label>
						<input id="RoomN" size="20" maxlength="6" type="text" name="RoomN" placeholder="ITE200" required>
				</div>	
				<br>

				<div class="nextButton">
					<input type="submit" name="next" class="button large go" value="Submit">
				</div>
				</form>
			</div>
			<form method="link" action="AdminUI.php">
				<input type="submit" name="home" class="button large" value="Cancel">
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