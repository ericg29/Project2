<?php
session_start();

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

$firstn = urlencode($firstN);
$lastn = urlencode($lastN);
$studid = $_SESSION["studID"];
$Email = urlencode($email);
$Major = urlencode($major);

$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
if($_POST["studExist"] == true){
	$sql = "update `Proj2Students` set `FirstName` = '$firstN', `LastName` = '$lastN', `Email` = '$email', `Major` = '$major' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

header("Location: 02StudHome.php?firstN=$firstn&lastN=$lastN&email=$Email&major=$Major");
?>