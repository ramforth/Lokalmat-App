<?php
	setcookie("userID", $userID, time() - 3600, "/"); // 1 år
	setcookie("pw", $pw, time() + ( - 3600), "/"); // 1 år
	
	$warning = "Du har logget deg ut";
?>