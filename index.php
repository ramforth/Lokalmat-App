<?php
	//Henter Skjemadata
	$action = $_REQUEST['action'];
	$ysteriID = $_REQUEST['ysteriID'];
	$userAction = $_REQUEST['userAction'];
	$email = $_REQUEST['email'];
	$pw = $_REQUEST['pw'];
	$pw2 = $_REQUEST['pw2'];
	
	//Henter Cookie data
	$userID = $_COOKIE["userID"];
	$guestID = $_COOKIE["guestID"];
	//$email = $_COOKIE["email"];
	//$pw = $_COOKIE["pw"];
	
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- DATABASE ------------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
 //Henter database tilkobling
 require "config/database.php";
 
  /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- SKJEMADATA ------------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
 include "moduls/prosessing/userProsess.php";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Lokalmat</title>
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1, initial-scale = 1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/default-theme.css">
		<link rel="stylesheet" href="css/animations.css">
	</head>
	<body class='bg-default'>
		<header class="header">
			<h1>Lokalmat</h1>
			<i class='warning'><?php echo "$warning"; ?></i>
		</header>
		
		<?php
			
			if ($action == 'menu') {
				include "pages/menu/menu-view.php";
			} else if ($action == 'ysteri' AND $ysteriID) {
				include "pages/ysteri/ysteri.php";
			} else if ($action == 'mittysteri') {
				include "pages/mittYsteri/main.php";
			} else if ($action == 'minside' OR $action == 'slettfavotritt') {
				include "pages/minSide/main.php";
			}else if ($action == 'map') {
				include "pages/firstPage/include-map-view.php";
			} else if ($action == 'logginnut' OR $action == 'login' OR $action == 'logut' OR $action == 'nyBrukerSkjema' OR $action == 'nyBruker') {
				include "pages/login/login.php";
			} else if ($action == 'list' Or $action == '') {
				include "pages/firstPage/include-list-view.php";
			}
			
		?>
		
		<div class='100-air'></div>
		<?php
			include "moduls/footer/footer.php";
		?>
	</body>
</html>