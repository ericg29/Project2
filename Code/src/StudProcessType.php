<?php
session_start();

$firstN = urlencode($_POST["firstN"]);
$lastN = urlencode($_POST["lastN"]);
$email = urlencode($_POST["email"]);
$major = urlencode($_POST["major"]);
if ($_POST["type"] == "Group"){
	$advisor = urlencode($_POST["type"]);
	header("Location: 08StudSelectTime.php?advisor=$advisor&firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
elseif ($_POST["type"] == "Individual"){
	header("Location: 07StudSelectAdvisor.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
?>