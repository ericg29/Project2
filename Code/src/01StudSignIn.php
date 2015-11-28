<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>UMBC COEIT Engineering and Computer Science Advising Student Sign In</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <body>
		
	<div class="container" style="min-height: 300px">
	<div id="header"><div><h3 style="position: relative; top: 5px;">This works best using any browser <u>OTHER</u> than Internet Explorer.</h3></div></div>
	<div class="container main" style="top: 0px; min-height: 300px;">
	<div id="sectionFull" style="min-height: 300px;">
<h1>COEIT Engineering and Computer Science Advising</h1>
		<h2>Student Sign In</h2><br>

		<!-- Form for login information -->
        <form action="StudProcessSignIn.php" method="post" name="SignIn">
	    <div class="field">
	      <label for="firstN">First Name</label>
	      <input id="firstN" size="30" maxlength="20" type="text" name="firstN" required autofocus>
	    </div>
	    <div class="field">
	      <label for="lastN">Last Name</label>
	      <input id="lastN" size="30" maxlength="20" type="text" name="lastN" required>
	    </div>
        <div class="field">
            <label for="studID">Student ID</label>
            <input id="studID" size="30" maxlength="7" type="text" pattern="[A-Za-z]{2}[0-9]{5}" title="AB12345" placeholder="AB12345" name="studID" required>
        </div>
		<div class="field">
            <label for="email">E-mail</label>
            <input id="email" size="30" maxlength="40" type="email" name="email" placeholder="student1@umbc.edu" required>
        </div>
        <div class="field">
              <label for="major">Major</label>
              <select id="major" name = "major">
				<option>Engineering Undecided</option>
				<option>Computer Engineering</option>
				<option>Computer Science</option>
				<option>Mechanical Engineering</option>
				<option>Chemical Engineering</option>
				<!-- Maybe one day ---------------------------
				<option>Africana Studies</option>
				<option>American Studies</option>
				<option>Ancient Studies</option>
				<option>Anthropology</option>
				<option>Asian Studies</option>
				<option>Biochemistry and Molecular Biology</option>
				<option>Bioinformatics and Computational Biology</option>
				<option>Biological Sciences</option>
				<option>Business Technology Administration</option>
				<option>Chemistry</option>
				<option>Dance</option>
				<option>Economics</option>
				<option>Financial Economics</option>
				<option>Emergency Health Services</option>
				<option>English</option>
				<option>Environmental Science and Environmental Studies</option>
				<option>Gender and Women's Studies</option>
				<option>Geography</option>
				<option>Global Studies</option>
				<option>Health Administration and Policy</option>
				<option>History</option>
				<option>Information Systems</option>
				<option>Interdisciplinary Studies</option>
				<option>Management of Aging Services</option>
				<option>Mathematics</option>
				<option>Statistics</option>
				<option>Media and Communication Studies</option>
				<option>Modern Languages, Linguistics and Intercultural Communication</option>
				<option>Music</option>
				<option>Philosophy</option>
				<option>Physics</option>
				<option>Political Science</option>
				<option>Psychology</option>
				<option>Social Work</option>
				<option>Sociology</option>
				<option>Theatre</option>
				<option>Visual Arts</option>
				<option>Undecided</option>
				<option>Other</option> -->
				</select>
        </div>
	    <div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Next">
	    </div>
		<br>
		<b><font color="red" size="3">This is in TESTING mode only!!! You are creating simulated appointments!!!</font></b>
		<br>
	</div>
	<?php
		include('./footer.php');
	?>
	</div>
  </body>
  
</html>


