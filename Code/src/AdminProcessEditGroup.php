<?php
session_start();

$groupApp = $_POST["GroupApp"];
$delete = false;

if ($_POST["next"] == "Delete Appointment"){
	$delete = true;
	$advisor = $_POST["next"];
	header('Location: AdminConfirmEditGroup.php? groupApp=$groupApp & delete=$delete & advisor=$advisor');
}
elseif ($_POST["next"] == "Edit Appointment"){

	header('Location: AdminProceedEditGroup.php? groupApp=$groupApp');
}

?>

