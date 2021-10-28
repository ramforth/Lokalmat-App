<?php
	if ($userID) {
		//Brukeren er innlogget.
		if ($action == 'logut') {
			include "pages/login/logutProsess.php";
		}
		
		loggutSchema();
		
	} else {
		//Brukeren er ikke innlogget.
		if ($action == 'login' AND $email AND $pw) {
			include "pages/login/loginProsess.php";
			
		} else if ($action == 'nyBrukerSkjema') {
			nyBrukerSkjema();
			
		} else if ($action == 'nyBruker' AND $email AND $pw AND $pw2) {
			include "nyBrukerRegister.php";
			
		} else {
			loginScema();
		}
		
	}
	
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- FUNKSJONER ------------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
	
	//-------------------------------------------
	//LOGIN SKJEMA
	//-------------------------------------------
	
	function loginScema() {
		echo "
			<form class='flex-column bg-white' action='index.php' method='GET'>
					<b class='mp5 center'>Brukernavn:</b>
					<input class='center' type='email' name='email' value='$email' placeholder='din@epost.no'>
				
					<b class='mp5 center'>Passord:</b>
					<input class='center' type='password' name='pw' value='$pw' minlenght='8' required>
					
					<button class='bStandard muted' name='action' value='login'>Logg inn</button>
			</form>
		";
		
		alternativ();
	}
	
	//-------------------------------------------
	//LOGG UT SKJEMA
	//-------------------------------------------
	function loggutSchema() {
		echo "
			<form class='flex-column' action='index.php' method='GET'>
				<button class='bStandard muted' name='action' value='logut'>Logg ut</button>
			</form>
		";
	}
	
	//-------------------------------------------
	//Registrer ny bruker skjema
	//-------------------------------------------
	
	function nyBrukerSkjema() {
		echo "
			<form class='flex-column bg-white' action='index.php' method='get'>
				<b class='mp5 center'>Epost:</b>
				<input class='center' type='email' name='email' required>
				
				<b class='mp5 center'>Passord:</b>
				<input class='center' type='password' name='pw' minlength='8' required>
				
				<b class='mp5 center'>Gjenta passord:</b>
				<input class='center' type='password' name='pw2' minlength='8' required>
				
				<button class='bStandard muted' name='action' value='nyBruker'>Registrer</button>
			</form>
			
			<div class='flex-column mp5 bg-white'>
				<b>Vilkår:</b>
				
				<div>
					<p>Vilkår for registrering...</p>
				</div>
			</div>
		";
	}


	function alternativ() {
		echo "
			<form class='flex-column' action='index.php' method='get'>
				<button class='bStandard muted' name='action' value='nyBrukerSkjema'>Registrer</button>
			</form>
		";
	}
	
	function loginSucsess() {
		echo "
			<form class='flex-column' action='index.php' method='get'>
				<button class='bStandard muted' name='action' value='minside'>ok</button>
			</form>
		";
	}
?>