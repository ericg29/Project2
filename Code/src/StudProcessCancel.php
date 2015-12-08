<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

$firstN = $_POST["firstN"];
$lastN = $_POST["lastN"];
$email = $_POST["email"];
$major = $_POST["major"];

$firstn = urlencode($firstN);
$lastn = urlencode($lastN);
$Email = urlencode($email);
$Major = urlencode($major);

if($_POST["cancel"] == 'Cancel'){
	$studid = $_SESSION["studID"];
	
	//remove stud from EnrolledID
	$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);
	$oldAdvisorID = $row[2];
	$oldAppTime = $row[1];
	$newIDs = str_replace($studid, "", $row[4]);
	
	$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum-1, `EnrolledID` = '$newIDs' where `AdvisorID` = '$oldAdvisorID' and `Time` = '$oldAppTime'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	//update stud status to noApp
	$sql = "update `Proj2Students` set `Status` = 'N' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	$_SESSION["status"] = "cancel";
}
else{
	$_SESSION["status"] = "keep";
}
header("Location: 12StudExit.php?firstN=$firstn&lastN=$lastn&email=$Email&major=$Major");
?>