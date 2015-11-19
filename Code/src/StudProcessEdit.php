<?php
session_start();

$_SESSION["firstN"] = strtoupper($_POST["firstN"]);
$_SESSION["lastN"] = strtoupper($_POST["lastN"]);
$_SESSION["email"] = $_POST["email"];

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

$firstn = $_SESSION["firstN"];
$lastn = $_SESSION["lastN"];
$studid = $_SESSION["studID"];
$email = $_SESSION["email"];
$major = $_SESSION["major"];

$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
if($_SESSION["studExist"] == true){
	$sql = "update `Proj2Students` set `FirstName` = '$firstn', `LastName` = '$lastn', `Email` = '$email', `Major` = '$major' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

header('Location: 02StudHome.php');
?>