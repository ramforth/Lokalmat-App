<?php
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- REGISTRERER NY BRUKER -----------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
 	//-------------------------------------------
	//SJEKKER passord stemmer overens
	//-------------------------------------------
	
	if ($pw == $pw2) {
		$pw2 = true;
	} else {
		echo "Passordet er feil!";
	}
	
 	//-------------------------------------------
	//Sjekker om ikke det finnes ugyldige tegn
	//-------------------------------------------
	
	$check = true;
	
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- LAGRER BRUKER I DATABASE -----------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
	
 	//-------------------------------------------
	//OM ALT STEMMER OVERENS
	//-------------------------------------------
	if ($pw2 == true AND $check == true) {
		
		//-------------------------------------------
		//SQL
		//-------------------------------------------
		$sql = "INSERT INTO users (userID, email, pw)
					VALUES ('', '$email', '$pw')";
									
		//Skriver til database
		if ($conn->query($sql) === TRUE) {
			//-------------------------------------------
			//HVIS SQL GIKK GREIT, SENDER VI BRUKEREN TIL LOGIN
			//-------------------------------------------
			loginScema();
		} else {
			//-------------------------------------------
			//NOE GIKK GALT, VI BER BRUKEREN PRØVE PÅ NYTT
			//-------------------------------------------
			
			$warning = "Noe gikk galt.";
			nyBrukerSkjema();
		}
	}
?>