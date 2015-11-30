<html lang="en">
  <head>
    <meta charset="UTF-8" />
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
  </head>
  <div id="footer">
	<div id="footer_image" title="UMBC: An Honors University in Maryland"></div>
	<?php
		if ($_SESSION["admin"] == true) {
			echo "<div class=\"adminFooter\">";
		}
		else {
			echo "<div class=\"studFooter\">";
		}
	?>		
		<h4>© University of Maryland, Baltimore County  |  1000 Hilltop Circle  |  Baltimore, MD 21250</h4>
		<div style="position: relative; top: -8px; margin: 0px 10px;">
			<a class="footer_links" href="http://coeit.umbc.edu/">UMBC COEIT Website</a>
			<h5> |  </h5>
			<a class="footer_links" href="http://advising.coeit.umbc.edu/">COEIT Advising Website</a>
			<h5> |  </h5>
			<a class="footer_links" href="http://advising.coeit.umbc.edu/contact-us/">Contact the Advisors</a>
			</div>
	</div>
	<?php
	if ($_SESSION["admin"] == true) {
		echo "<div>";
		include('./workOrder/workButton.php');
		echo "</div>";
	}
	?>
  </div>
 </html>