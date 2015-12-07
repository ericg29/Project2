<?php
session_start();

$groupApp = urlencode($_POST["groupApp"]);


if ($_POST["next"] == "Delete Appointment"){
	$advisor = urlencode($_POST["next"]);
	header("Location: AdminConfirmEditGroup.php?advisor=$advisor&delete=true&groupApp=$groupApp");
}
elseif ($_POST["next"] == "Edit Appointment"){
	header("Location: AdminProceedEditGroup.php?delete=false&groupApp=$groupApp");
}

?>