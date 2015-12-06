<?php
session_start();
include('./header.php');

$firstN = strtoupper($_POST["firstN"]);
$lastN = strtoupper($_POST["lastN"]);
$email = $_POST["email"];

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

$studid = $_SESSION["studID"];

$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
if($studExist == true){
	$sql = "update `Proj2Students` set `FirstName` = '$firstN', `LastName` = '$lastN', `Email` = '$email', `Major` = '$major' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

header('Location: 02StudHome.php');
?>