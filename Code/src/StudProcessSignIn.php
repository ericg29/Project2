<?php
session_start();

//set session variables
$_SESSION["firstN"] = strtoupper($_POST["firstN"]);
$_SESSION["lastN"] = strtoupper($_POST["lastN"]);
$_SESSION["studID"] = strtoupper($_POST["studID"]);
$_SESSION["email"] = $_POST["email"];

//set "major" to the appropriate abbreviation for the major selected
if($_POST["major"] == "Chemical Engineering")
{
	$_SESSION["major"] = 'CENG';
}
elseif($_POST["major"] == "Computer Engineering")
{
	$_SESSION["major"] = 'CMPE';
}
elseif($_POST["major"] == "Computer Science")
{
	$_SESSION["major"] = 'CMSC';
}
elseif($_POST["major"] == "Mechanical Engineering")
{
	$_SESSION["major"] = 'MENG';
}
else
{
	$_SESSION["major"] = 'ENGR';	
}

header('Location: 02StudHome.php');
?>