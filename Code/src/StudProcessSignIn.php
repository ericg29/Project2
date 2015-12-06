<?php
session_start();

//set session variables
$firstN = strtoupper($_POST["firstN"]);
$lastN = strtoupper($_POST["lastN"]);
$_SESSION["studID"] = strtoupper($_POST["studID"]);
$email = $_POST["email"];

//set "major" to the appropriate abbreviation for the major selected
if($_POST["major"] == "Chemical Engineering")
{
	$major = 'CENG';
}
elseif($_POST["major"] == "Computer Engineering")
{
	$major = 'CMPE';
}
elseif($_POST["major"] == "Computer Science")
{
	$major = 'CMSC';
}
elseif($_POST["major"] == "Mechanical Engineering")
{
	$major = 'MENG';
}
else
{
	$major = 'ENGR';	
}

header('Location: 02StudHome.php');
?>