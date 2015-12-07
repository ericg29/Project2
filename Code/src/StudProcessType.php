<?php
session_start();
if ($_POST["type"] == "Group"){
	$advisor = urlencode($_POST["type"]);
	header("Location: 08StudSelectTime.php?advisor=$advisor");
}
elseif ($_POST["type"] == "Individual"){
	header('Location: 07StudSelectAdvisor.php');
}
?>