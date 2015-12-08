<?php
session_start();

if ($_POST["next"] == "Group"){
	$advisor = urlencode($_POST["next"]);
	header("Location: AdminScheduleGroup.php?advisor=$advisor");
}
elseif ($_POST["next"] == "Individual"){
	header('Location: AdminScheduleInd.php');
}

?>