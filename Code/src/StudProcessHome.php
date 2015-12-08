<?php
session_start();

$firstN = urlencode($_POST["firstN"]);
$lastN = urlencode($_POST["lastN"]);
$email = urlencode($_POST["email"]);
$major = urlencode($_POST["major"]);

if($_POST["selection"] == 'Signup'){
	header("Location: 03StudSelectType.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
elseif($_POST["selection"] == 'View'){
	header("Location: 04StudViewApp.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
elseif($_POST["selection"] == 'Reschedule'){
	$_SESSION["resch"] = true;
	header("Location: 03StudSelectType.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
elseif($_POST["selection"] == 'Cancel'){
	header("Location: 05StudCancelApp.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
elseif($_POST["selection"] == 'Search'){
	header("Location: 09StudSearchApp.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
elseif($_POST["selection"] == 'Edit'){
	header("Location: 06StudEditInfo.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}
elseif($_POST["selection"] == 'Next'){
	header("Location: 14StudSelectTypeNext.php?firstN=$firstN&lastN=$lastN&email=$email&major=$major");
}

?>