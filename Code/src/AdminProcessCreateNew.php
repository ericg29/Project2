<?php
session_start();

$AdvF = $_POST["firstN"];
$AdvL = $_POST["lastN"];
$_SESSION["UserN"] = $_POST["UserN"];
$_SESSION["PassW"] = $_POST["PassW"];
$AdvRN = $_POST["RoomN"];
$AdvMeet = $_POST["MeetingRoom"];
$PassCon = false;

$firstn = urlencode($AdvF);
$lastn = urlencode($AdvL);
$room = urlencode($AdvRN);
$meet = urlencode($AdvMeet);

if($_POST["PassW"] == $_POST["ConfP"]){
	header("Location: AdminCreateNew.php?firstN=$firstn&lastN=$lastn&room=$room&meet=$meet");
}
elseif($_POST["PassW"] != $_POST["ConfP"]){
	$PassCon = true;
	$passcon = urlencode($PassCon);
	header("Location: AdminCreateNewAdv.php?PassCon=$passcon");
}

?>