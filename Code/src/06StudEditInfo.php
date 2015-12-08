<?php
session_start();
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Student Information</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
	<div class="container">
	<?php
		include('./header.php');
		if(isset($_GET["firstN"])){$firstN = $_GET["firstN"];}
		else{$firstN = $_POST["firstN"];}
		if(isset($_GET["lastN"])){$lastN = $_GET["lastN"];}
		else{$lastN = $_POST["lastN"];}
		if(isset($_GET["email"])){$email = $_GET["email"];}
		else{$email = $_POST["email"];}
		if(isset($_GET["major"])){$major = $_GET["major"];}
		else{$major = $_POST["major"];}
		
		//get student that matches ID
		$sql = "select * from Proj2Students WHERE `StudentID` = " . "\"" . $_SESSION["studID"] . "\"";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
	?>
	<div class="container main">
	<div id="nav">
		<form action="StudProcessHome.php" method="post" name="Home">
		<?php
			echo("<input type=\"hidden\" name=\"firstN\" value=\"$firstN\">");
			echo("<input type=\"hidden\" name=\"lastN\" value=\"$lastN\">");
			echo("<input type=\"hidden\" name=\"email\" value=\"$email\">");
			echo("<input type=\"hidden\" name=\"major\" value=\"$major\">");
			if ($studExist == false || $adminCancel == true || $noApp == true){
				
				echo "<button type='submit' name='selection' class='button main selection' value='Signup'>Signup for an appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Next'>Find the next available appointment</button><br>";
			}
			else{
				echo "<button type='submit' name='selection' class='button main selection' value='View'>View my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Reschedule'>Reschedule my appointment</button><br>";
				echo "<button type='submit' name='selection' class='button main selection' value='Cancel'>Cancel my appointment</button><br>";
			}
			echo "<button type='submit' name='selection' class='button main selection' value='Search'>Search for appointment</button><br>";
			echo "<div class='button selected'>Edit student information</div><br>";
		?>
		</form>
	</div>
	<div id="section">
		<div class="top">
			<h2>Edit Student Information<span class="login-create"></span></h2>
			<form action="StudProcessEdit.php" method="post" name="Edit">
				<?php echo("<input type=\"hidden\" name=\"studExist\" value=\"$studExist\">"); ?>
			<div class="field">
				<label for="firstN">First Name</label>
				<input id="firstN" size="30" maxlength="50" type="text" name="firstN" required value=<?php echo $firstN?>>
			</div>
			<div class="field">
			  <label for="lastN">Last Name</label>
			  <input id="lastN" size="30" maxlength="50" type="text" name="lastN" required value=<?php echo $lastN?>>
			</div>
			<div class="field">
				<label for="studID">Student ID</label>
				<input id="studID" size="30" maxlength="7" type="text" pattern="[A-Za-z]{2}[0-9]{5}" title="AB12345" name="studID" disabled value=<?php echo $_SESSION["studID"]?>>
			</div>
			<div class="field">
				<label for="email">E-mail</label>
				<input id="email" size="30" maxlength="255" type="email" name="email" required value=<?php echo $email?>>
			</div>
			<div class="field">
				  <label for="major">Major</label>
				  <select id="major" name = "major">
					<option <?php if($major == 'ENGR'){echo("selected");}?>>Engineering Undecided</option>
					<option <?php if($major == 'CMPE'){echo("selected");}?>>Computer Engineering</option>
					<option <?php if($major == 'CMSC'){echo("selected");}?>>Computer Science</option>
					<option <?php if($major == 'MENG'){echo("selected");}?>>Mechanical Engineering</option>
					<option <?php if($major == 'CENG'){echo("selected");}?>>Chemical Engineering</option>
<!-- someday
					<option <?php if($major == 'Africana Studies'){echo("selected");}?>>Africana Studies</option>
					<option <?php if($major == 'American Studies'){echo("selected");}?>>American Studies</option>
					<option <?php if($major == 'Ancient Studies'){echo("selected");}?>>Ancient Studies</option>
					<option <?php if($major == 'Anthropology'){echo("selected");}?>>Anthropology</option>
					<option <?php if($major == 'Asian Studies'){echo("selected");}?>>Asian Studies</option>
					<option <?php if($major == 'Biochemistry and Molecular Biology'){echo("selected");}?>>Biochemistry and Molecular Biology</option>
					<option <?php if($major == 'Bioinformatics and Computational Biology'){echo("selected");}?>>Bioinformatics and Computational Biology</option>
					<option <?php if($major == 'Biological Sciences'){echo("selected");}?>>Biological Sciences</option>
					<option <?php if($major == 'Business Technology Administration'){echo("selected");}?>>Business Technology Administration</option>
					<option <?php if($major == 'Chemistry'){echo("selected");}?>>Chemistry</option>
					<option <?php if($major == 'Dance'){echo("selected");}?>>Dance</option>
					<option <?php if($major == 'Economics'){echo("selected");}?>>Economics</option>
					<option <?php if($major == 'Financial Economics'){echo("selected");}?>>Financial Economics</option>
					<option <?php if($major == 'Emergency Health Services'){echo("selected");}?>>Emergency Health Services</option>
					<option <?php if($major == 'English'){echo("selected");}?>>English</option>
					<option <?php if($major == 'Environmental Science and Environmental Studies'){echo("selected");}?>>Environmental Science and Environmental Studies</option>
					<option <?php if($major == 'Gender and Womens Studies'){echo("selected");}?>>Gender and Womens Studies</option>
					<option <?php if($major == 'Geography'){echo("selected");}?>>Geography</option>
					<option <?php if($major == 'Global Studies'){echo("selected");}?>>Global Studies</option>
					<option <?php if($major == 'Health Administration and Policy'){echo("selected");}?>>Health Administration and Policy</option>
					<option <?php if($major == 'History'){echo("selected");}?>>History</option>
					<option <?php if($major == 'Information Systems'){echo("selected");}?>>Information Systems</option>
					<option <?php if($major == 'Interdisciplinary Studies'){echo("selected");}?>>Interdisciplinary Studies</option>
					<option <?php if($major == 'Management of Aging Services'){echo("selected");}?>>Management of Aging Services</option>
					<option <?php if($major == 'Mathematics'){echo("selected");}?>>Mathematics</option>
					<option <?php if($major == 'Statistics'){echo("selected");}?>>Statistics</option>
					<option <?php if($major == 'Media and Communication Studies'){echo("selected");}?>>Media and Communication Studies</option>
					<option <?php if($major == 'Modern Languages, Linguistics and Intercultural Communication'){echo("selected");}?>>Modern Languages, Linguistics and Intercultural Communication</option>
					<option <?php if($major == 'Music'){echo("selected");}?>>Music</option>
					<option <?php if($major == 'Philosophy'){echo("selected");}?>>Philosophy</option>
					<option <?php if($major == 'Physics'){echo("selected");}?>>Physics</option>
					<option <?php if($major == 'Political Sciences'){echo("selected");}?>>Political Science</option>
					<option <?php if($major == 'Psychology'){echo("selected");}?>>Psychology</option>
					<option <?php if($major == 'Social Work'){echo("selected");}?>>Social Work</option>
					<option <?php if($major == 'Sociology'){echo("selected");}?>>Sociology</option>
					<option <?php if($major == 'Theatre'){echo("selected");}?>>Theatre</option>
					<option <?php if($major == 'Visual Arts'){echo("selected");}?>>Visual Arts</option>
					<option <?php if($major == 'Undecided'){echo("selected");}?>>Undecided</option>
					<option <?php if($major == 'Other'){echo("selected");}?>>Other</option>
-->
					</select>
			</div>
			<div class="nextButton">
				<input type="submit" name="save" class="button large go" value="Save">
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