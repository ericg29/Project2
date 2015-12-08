<?php
session_start();

$AdvF = $_POST["firstN"];
$AdvL = $_POST["lastN"];
$_SESSION["UserN"] = $_POST["UserN"];
$_SESSION["PassW"] = $_POST["PassW"];
$AdvRN = $_POST["RoomN"];
$AdvMeet = $_POST["MeetingRoom"];
$PassCon = false;

if($_POST["PassW"] == $_POST["ConfP"]){
	header('Location: AdminCreateNew.php');
}
elseif($_POST["PassW"] != $_POST["ConfP"]){
	$PassCon = true;
	$passcon = urlencode($PassCon);
	header("Location: AdminCreateNewAdv.php?PassCon=$passcon");
}

?>