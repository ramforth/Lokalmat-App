<div id='main'>
<?php
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- MITT YSTERI ----------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/

  	//-------------------------------------------
	//sjekker om brukeren er logget inn
	//-------------------------------------------
	
	if ($userID) {

		//-------------------------------------------
		//Sjekker userAction
		//-------------------------------------------
		
		//Nytt Ysteri / Utsalgs sted
		if ($userAction == 'nyttYsteri') {
			lagreNyttYsteri($conn, $userID, $imagefile);
		}
			

		//-------------------------------------------
		//sjekker om brukeren har et Ysteri
		//-------------------------------------------
		
		harYsteri($conn, $userID, $ysteriID, $userAction);

		  	//-------------------------------------------
			//Viser resultat
			//-------------------------------------------
			
		
	} else {
		
		echo "Du må være logget inn!";
	}
	
	
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- FUNKSJONER ----------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//sjekker om brukeren har et Ysteri
	//------------------------------------------------------------------------------------------------------------------------------------------
	
	function harYsteri($conn, $userID, $ysteriID, $userAction) {
		
		//-------------------------------------------
		//SQL Spørring: Henter vavoritt ID
		//-------------------------------------------
		$sql = "SELECT tilbyderID FROM tilbydere WHERE userID = '$userID'";
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)) {
			$ysteriID = $row["tilbyderID"];
		}
		
		if ($ysteriID) {
				
			//-------------------------------------------
			//Ysteri finnes, viser siden
			//-------------------------------------------
			
			//Menyen

			echo "<form action='index.php' method='POST' class='flex-row' style='border-bottom-style: solid; border-bottom-width: 1px; margin-bottom: 5px;'>
					<input type='number' class='hidden' name='ysteriID' value='$ysteriID'>
					<input type='text' class='hidden' name='action' value='mittysteri'>
					
					<div clasS='row-2 secondary'>
						<button class='fane secondary' name='userAction' value='mittYsteri'>Profil</button>
					</div>
					<div clasS='row-2 primarly'>
						<button class='fane row-2 primarly' name='userAction' value='Produkter'>Produkter</button>
					</div>
			</form>";
			
			if ($userAction == 'utsalgEdit') {
				//Viser edit skjema
				utsalgEdit($conn);
				
			} else if ($userAction == 'editForetakLagre') {
				
				//Oppdatere foretaket
				editForetakLagre($conn);
				
				//Viser Foretaket
				ysteriSideProfil($conn, $userID);
				
			} else if ($userAction == 'Produkter') {

				//Viser Produktene
				produkter($conn, $userID);
				
			} else if ($userAction == 'nyProdukt') {
				
				nyttProdukt();
				
			} else if ($userAction == 'produktDelete') {
				
				//Slette produkt
				slettProdukt($conn);
				
				//Viser Produktene
				produkter($conn, $userID);

			} else if ($userAction == 'lagreNyProdukt') {
				
				lagreNyProdukt($conn, $userID);
				
			} else if ($userAction == 'produktEdit') {
				
				editProdukt($conn);
				
			} else if ($userAction == 'lagreEditertProdukt') {
				
				//Lagre editert Produkt
				lagreEditertProdukt($conn);
				
				//Viser Produktene
				produkter($conn, $userID);
				
			} else {
				
				ysteriSideProfil($conn, $userID);
				
			}
				
		} else {
			//-------------------------------------------
			//Ysteri finnes ikke, viser reg. skjema
			//-------------------------------------------

			ysteriRegSkjema($imagefile);
		}
	}
	
   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Ysteri registrerings skjema
	//------------------------------------------------------------------------------------------------------------------------------------------
	function ysteriRegSkjema($imagefile) {
		
		$imagefile = $_POST['imagefile'];
		
		echo "
				<div class='bg-white mp5'>
					<h3>Registrer nytt Ysteri</h3>
					<b>Vi fant ikke registrert noe Ysteri på din brukerkonto...</b>
					
					<p>Hvis du driver et Ysteri foretak, er du hjertelig velkommen til å registrere det her,
					slik at alle brukerne kan finne og komme i kontakt for å handle lokalt.</p>
					
					<p>Vi har ikke mange krav, foruten at Ysteriet er et gyldig registrert foretak med org. nummer.</p>
				</div>
				
				<form class='flex-column center' action='index.php' method='POST' enctype='multipart/form-data'>
					<div class='flex-column bg-white' style='margin-bottom: 10px; padding-bottom: 5px;'>
						<input type='text' class='hidden' name='action' value='mittysteri'>
						
						<b>Ysteri navn:</b>
						<input type='text' name='foretak_navn' requried>
						
						<b>Organisasjons nummer:</b>
						<input type='number' name='orgnr' minlength='11' maxlength='11' requried>
						
						<b>Beskrivelse:</b>
						<textarea rows='5' name='om' maxlength='500'></textarea>
						
						<label for='imagefile' class='flex-column center'>
							<b>Profilbilde:</b>
							<img class='ico' src='img/ico/camera_ico.png' alt='camera_ico'>
							<p>Last opp profil bilde!</p>
						</label>
						
						<input type='file' style='display: none;' class='camera' id='imagefile' name='imagefile' accept='image/*' capture='camera' onchange='loadFile(event)'>
						<img id='profil'/>
					</div>
					
					<div class='flex-column bg-white' style='margin-bottom: 10px; padding-bottom: 5px;'>
						<h3>Adresse</h3>
						
						<b>Adresse:</b>
						<input type='text' name='adresse' required>
						
						<b>post nummer:</b>
						<input type='number' name='postnummer' minlength='4' maxlength='4' length='4' required>
						
						<b>Sted:</b>
						<input type='text' name='sted' required>
						
						<b>Land:</b>
						<input type='text' name='land' value='Norge' readonly required>
					</div>
					
					<div class='flex-column bg-white' style='margin-bottom: 10px; padding-bottom: 5px;'>
						<h3>Kontakt opplysninger</h3>
						
						<b>Fornavn:</b>
						<input type='text' name='fornavn' required>
						
						<b>Etternavn:</b>
						<input type='text' name='etternavn' required>
						
						<b>Telefon nummer:</b>
						<input type='number' name='tlf' minlength='8' maxlength='8' required>
						
						<b>epost</b>
						<input type='text' name='epost' required>
					</div>
					
					<div class='mp5 primarly'>
						<button name='userAction' value='nyttYsteri' class='fane'>Lagre</button>
					</div>
				</form>
			";
	}

   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Ysteri Side Skjema
	//------------------------------------------------------------------------------------------------------------------------------------------
	
	function ysteriSideProfil($conn, $userID) {
		//-------------------------------------------
		//SQL: DATABASE
		//-------------------------------------------
		$sql = "SELECT tilbyderID, foretak_navn, orgnr, om, adresse, postnummer, sted, land, fornavn, etternavn, tlf, epost FROM tilbydere WHERE userID='$userID'";
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)) {
			$tilbyderID = $row["tilbyderID"];
			$foretak_navn = $row["foretak_navn"];
			$orgnr = $row["orgnr"];
			$om = $row["om"];
			$adresse = $row["adresse"];
			$postnummer = $row["postnummer"];
			$sted = $row["sted"];
			$land = $row["land"];
			$fornavn = $row["fornavn"];
			$etternavn = $row["etternavn"];
			$tlf = $row["tlf"];
			$epost = $row["epost"];
			}
		
		//Sub navn
		echo "<form action='index.php' method='POST' style='margin-bottom: 5px;'>
					<input type='text' class='hidden' name='action' value='mittysteri'>
					<input type='text' class='hidden' name='tilbyderID' value='$tilbyderID'>
					
					<div clasS='row-2 default'>
						<button class='fane' name='userAction' value='utsalgEdit'>Edit Profil</button>
					</div>
				</form>";
		
		//Header
		echo "<div class='flex-column muted center'>
			<div>
				</div>
					<div class='flex-row'>
						<h3>$foretak_navn</h3>
					</div>
					<div class='flex-row'>
						<p>$orgnr</p>
					</div>
				<div>
			</div>
			
			<img class='center' src='' alt='profilbilde'>
			
			<div>
				<p>$om</p>
			</div>
		</div>";
		
		//Gaards INFO
		echo "<div class='flex-column muted center' style='margin-top: 5px;'>
			<p><b>Adresse: </b>$adresse</p>
			<p><b>Postnummer: </b>$postnummer</p>
			<p><b>Sted: </b>$sted</p>
			<p><b>Land: </b>$land</p>
			<p><b>Fornavn: </b>$fornavn</p>
			<p><b>Etternavn: </b>$etternavn</p>
			<p><b>Telefon: </b>$tlf</p>
			<p><b>Epost: </b>$epost</p>
		</div>";
	}
	
   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Lagre nytt Ysteri
	//------------------------------------------------------------------------------------------------------------------------------------------
	
	function lagreNyttYsteri($conn, $userID) {
		
		   	//-------------------------------------------
			//INCLUDE: IMG upload
			//-------------------------------------------
			$imagefile = $_REQUEST['imagefile'];
			echo "$imagefile";
			include "moduls/mod_imgUpload/mod_imgUpload.php";
			
		   	//-------------------------------------------
			//SQL: INSERT
			//-------------------------------------------
			$stmt = $conn->prepare("INSERT INTO tilbydere (tilbyderID, userID, foretak_navn, orgnr, om, adresse, postnummer, sted, land, gps_lat, gps_long, fornavn, etternavn, tlf, epost, godkjent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("iisississssssssi", $null, $userID, $foretak_navn, $orgnr, $om, $adresse, $postnummer, $sted, $land, $null, $null, $fornavn, $etternavn, $tlf, $epost, $null);
			
		   	//-------------------------------------------
			//Henter skjemadata
			//-------------------------------------------
			
			$foretak_navn = $_REQUEST['foretak_navn'];
			$orgnr = $_REQUEST['orgnr'];
			$om = $_REQUEST['om'];
			$adresse = $_REQUEST['adresse'];
			$postnummer = $_REQUEST['postnummer'];
			$sted = $_REQUEST['sted'];
			$land = $_REQUEST['land'];
			//$gps_lat = $_REQUEST['gps_lat'];
			//$gps_long = $_REQUEST['gps_long'];
			$fornavn = $_REQUEST['fornavn'];
			$etternavn = $_REQUEST['etternavn'];
			$tlf = $_REQUEST['tlf'];
			$epost = $_REQUEST['epost'];
			
			$null = '';
		   	//-------------------------------------------
			//SQL: Lagrer data til database
			//-------------------------------------------
			
			//$stmt->execute();
			
			//$stmt->close();
			//$conn->close();
			
			//-------------------------------------------
			//FORM: Ok form
			//-------------------------------------------
			echo "<form action='index.php' method='POST'>
					<button name='action' value='mittysteri'>ok</button>
				</form>";
			
	}

   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Produkt siden
	//------------------------------------------------------------------------------------------------------------------------------------------
	function produkter($conn, $userID) {
		
		//-------------------------------------------
		//Legg til produkt skjema
		//-------------------------------------------
		echo "<form class='flex-row default' action='index.php' method='GET'>
					<input class='hidden' type='text' name='action' value='mittysteri'>
					<button class='fane' name='userAction' value='nyProdukt'>+ Nytt produkt</button>
		</form>";
		
		//-------------------------------------------
		//SQL: DATABASE - Henter produktene
		//-------------------------------------------
		$sql = "SELECT produktID, Pnavn, Pbeskrivelse, Ppris FROM produkter WHERE tilbyderID='$userID'";
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)) {
			$produktID = $row["produktID"];
			$Pnavn = $row["Pnavn"];
			$Pbeskrivelse = $row["Pbeskrivelse"];
			$Ppris = $row["Ppris"];
			
			echo "<form action='index.php' method='POST' class='flex-column'>
						<input class='hidden' type='text' name='action' value='mittysteri'>
						<input class='hidden' type='text' name='produktID' value='$produktID'>
						
						<div class='row-list bg-white mp5'>
							<div class='flex-row'>
								<img class='column-2' src='#' alt='produkt bilde'>
								<div class='column-2 flex-column'>
									<b>$Pnavn</b>
									<p>Pris: $Ppris,-</p>
								</div>
							</div>
							
							<p class='column-1 produktBeskrivelse'>$Pbeskrivelse</p>
							
							<div class='flex-row'>
								<div class='row-2'>
								</div>
								<div class='row-2 secondary'>
									<button class='fane' name='userAction' value='produktEdit'>Edit</button>
								</div>
								<div class='row-2 primarly'>
									<button class='fane' name='userAction' value='produktDelete'>Slett</button>
								</div>
							</div>
						</div>
					</form>";
		}
		
	}

   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Edit utsalgs sted
	//------------------------------------------------------------------------------------------------------------------------------------------
	function utsalgEdit($conn) {
		
		//-------------------------------------------
		//Henter skjema data
		//-------------------------------------------
		$tilbyderID = $_REQUEST["tilbyderID"];

		//-------------------------------------------
		//SQL: DATABASE - Henter Ysteri Data
		//-------------------------------------------
		$sql = "SELECT foretak_navn, orgnr, om, adresse, postnummer, sted, land, fornavn, etternavn, tlf, epost
				FROM tilbydere
				WHERE tilbyderID='$tilbyderID'";
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)) {

			$foretak_navn = $row["foretak_navn"];
			$orgnr = $row["orgnr"];
			$om = $row["om"];
			$adresse = $row["adresse"];
			$postnummer = $row["postnummer"];
			$sted = $row["sted"];
			$land = $row["land"];
			$fornavn = $row["fornavn"];
			$etternavn = $row["etternavn"];
			$tlf = $row["tlf"];
			$epost = $row["epost"];
			}
			
		//-------------------------------------------
		//Skjema
		//-------------------------------------------
		
		echo "
				<form class='flex-column center' action='index.php' method='GET'>
					<div class='flex-column bg-white' style='margin-bottom: 10px; padding-bottom: 5px;'>
						<input type='text' class='hidden' name='action' value='mittysteri'>
						<input type='text' class='hidden' name='tilbyderID' value='$tilbyderID'>
						
						<b>Foretaks navn:</b>
						<input type='text' name='foretak_navn' value='$foretak_navn' requried>
						
						<b>Organisasjons nummer:</b>
						<input type='number' name='orgnr' minlength='11' maxlength='11' value='$orgnr' requried>
						
						<b>Beskrivelse:</b>
						<textarea rows='5' name='om' maxlength='500'>$om</textarea>
					</div>
					
					<div class='flex-column bg-white' style='margin-bottom: 10px; padding-bottom: 5px;'>
						<h3>Adresse</h3>
						
						<b>Adresse:</b>
						<input type='text' name='adresse' value='$adresse' required>
						
						<b>post nummer:</b>
						<input type='number' name='postnummer' minlength='4' maxlength='4' length='4' value='$postnummer' required>
						
						<b>Sted:</b>
						<input type='text' name='sted' value='$sted' required>
						
						<b>Land:</b>
						<input type='text' name='land' value='Norge' readonly required>
					</div>
					
					<div class='flex-column bg-white' style='margin-bottom: 10px; padding-bottom: 5px;'>
						<h3>Kontakt opplysninger</h3>
						
						<b>Fornavn:</b>
						<input type='text' name='fornavn' value='$fornavn' required>
						
						<b>Etternavn:</b>
						<input type='text' name='etternavn' value='$etternavn' required>
						
						<b>Telefon nummer:</b>
						<input type='number' name='tlf' minlength='8' maxlength='8' value='$tlf' required>
						
						<b>epost</b>
						<input type='text' name='epost' value='$epost' required>
					</div>
					
					<div class='mp5 primarly'>
						<button name='userAction' value='editForetakLagre' class='fane'>Lagre</button>
					</div>
				</form>
			";
	}
	
	
	function editForetakLagre($conn) {
		   	//-------------------------------------------
			//Henter skjemadata
			//-------------------------------------------
			
			$tilbyderID = $_REQUEST['tilbyderID'];
			$foretak_navn = $_REQUEST['foretak_navn'];
			$orgnr = $_REQUEST['orgnr'];
			$om = $_REQUEST['om'];
			$adresse = $_REQUEST['adresse'];
			$postnummer = $_REQUEST['postnummer'];
			$sted = $_REQUEST['sted'];
			$land = $_REQUEST['land'];
			//$gps_lat = $_REQUEST['gps_lat'];
			//$gps_long = $_REQUEST['gps_long'];
			$fornavn = $_REQUEST['fornavn'];
			$etternavn = $_REQUEST['etternavn'];
			$tlf = $_REQUEST['tlf'];
			$epost = $_REQUEST['epost'];
			
		   	//-------------------------------------------
			//SQL: Lagrer data til database
			//-------------------------------------------
			
			$sql = "UPDATE tilbydere SET foretak_navn = '$foretak_navn', orgnr = '$orgnr', om = '$om', adresse = '$adresse', postnummer = '$postnummer', sted = '$sted', land = '$land', fornavn = '$fornavn', etternavn = '$etternavn', tlf = '$tlf', epost = '$epost'
						WHERE tilbyderID = '$tilbyderID'";
			
			// Prepare statement
			$stmt = $conn->prepare($sql);
			
			// execute the query
			$stmt->execute();
			
			
			//Skriver til database
			/*
			if ($conn->query($sql) === TRUE) {
				
			} else {
				echo "$sql";
			}
			*/
	}
	
   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Nytt produkt skjema
	//------------------------------------------------------------------------------------------------------------------------------------------
	function nyttProdukt() {
		
		//-------------------------------------------
		//Skjema
		//-------------------------------------------
			echo "<h3>Nytt produkt:</h3>";
			
			echo "<form action='index.php' method='POST'>
						<div class='flex-column center bg-white'>
							<input class='hidden' type='text' name='action' value='mittysteri'>
							
							<label>
								<b>Produkt navn:</b>
								<input type='text' name='Pnavn' maxlength='25' required>
							</label>
							
							<label>
								<b>Produkt beskrivelse:</b>
								<textarea name='Pbeskrivelse' rows='5' maxlength='250' required></textarea>
							</label>
							
							<label>
								<i>Bilde opplastning. Kommer...</i>
							</label>
							
							<label>
								<b>Pris:</b>
								<input type='text' name='Ppris' maxlength='4'>
							</label>
						</div>
						
						<div class='default mp5'>
							<button class='fane' name='userAction' value='lagreNyProdukt'>Lagre</button>
						</div>
					</form>";
			echo "<form action='index.php' method='POST'>
						<input class='hidden' type='text' name='action' value='mittysteri'>
						<div class='primarly mp5'>
							<button class='fane' name='userAction' value='Produkter'>Avbryt</button>
						</div>
				</form>";
	}

   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Edit Produkt
	//------------------------------------------------------------------------------------------------------------------------------------------
	function editProdukt($conn) {
		
		//-------------------------------------------
		//Henter form data
		//-------------------------------------------
		
		$produktID = $_REQUEST['produktID'];
		
		//-------------------------------------------
		//SQL: DATABASE - Henter produktene
		//-------------------------------------------
		$sql = "SELECT Pnavn, Pbeskrivelse, Ppris FROM produkter WHERE produktID='$produktID'";
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)) {
			$Pnavn = $row["Pnavn"];
			$Pbeskrivelse = $row["Pbeskrivelse"];
			$Ppris = $row["Ppris"];
		}
		
		//-------------------------------------------
		//Skjema
		//-------------------------------------------
			echo "<h3>Oppdater produkt:</h3>";
			
			echo "<form action='index.php' method='POST'>
						<div class='flex-column center bg-white'>
							<input class='hidden' type='text' name='action' value='mittysteri'>
							<input class='hidden' type='text' name='produktID' value='$produktID'>
							
							<label>
								<b>Produkt navn:</b>
								<input type='text' name='Pnavn' maxlength='25' value='$Pnavn' required>
							</label>
							
							<label>
								<b>Produkt beskrivelse:</b>
								<textarea name='Pbeskrivelse' rows='5' maxlength='250' required>$Pbeskrivelse</textarea>
							</label>
							
							<label>
								<i>Bilde opplastning. Kommer...</i>
							</label>
							
							<label>
								<b>Pris:</b>
								<input type='text' name='Ppris' maxlength='4' value='$Ppris'>
							</label>
						</div>
						
						<div class='default mp5'>
							<button class='fane' name='userAction' value='lagreEditertProdukt'>Lagre</button>
						</div>
					</form>";
			echo "<form action='index.php' method='POST'>
						<input class='hidden' type='text' name='action' value='mittysteri'>
						<div class='primarly mp5'>
							<button class='fane' name='userAction' value='Produkter'>Avbryt</button>
						</div>
				</form>";
	}

   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Lagre nytt produkt
	//------------------------------------------------------------------------------------------------------------------------------------------
	function lagreNyProdukt($conn, $userID) {

		//-------------------------------------------
		//Henter skjema data
		//-------------------------------------------
		$Pnavn = $_REQUEST['Pnavn'];
		$Pbeskrivelse = $_REQUEST['Pbeskrivelse'];
		$Ppris = $_REQUEST['Ppris'];
		
		//-------------------------------------------
		//SQL
		//-------------------------------------------
		$sqlNyP = "INSERT INTO produkter (produktID, tilbyderID, Pnavn, Pbeskrivelse, Ppris)
					VALUES ('', '$userID', '$Pnavn', '$Pbeskrivelse', '$Ppris')";
									
		//-------------------------------------------
		//SQL: Skriver til database
		//-------------------------------------------
		if ($conn->query($sqlNyP) === TRUE) {
			
		}
		
		//-------------------------------------------
		//Viser produkt siden
		//-------------------------------------------
		echo "<form class='flex-row default' action='index.php' method='POST'>
					<input type='text' class='hidden' name='action' value='mittysteri'>
					<button class='fane' name='userAction' value='Produkter'>ok</button>
				</form>";
	}
	
   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Lagre Editert produkt
	//------------------------------------------------------------------------------------------------------------------------------------------
	function lagreEditertProdukt($conn) {
		
		//-------------------------------------------
		//Henter skjema data
		//-------------------------------------------
		$produktID = $_REQUEST["produktID"];
		$Pnavn = $_REQUEST['Pnavn'];
		$Pbeskrivelse = $_REQUEST['Pbeskrivelse'];
		$Ppris = $_REQUEST['Ppris'];
		
		//-------------------------------------------
		//SQL
		//-------------------------------------------
		$sqlEditP = "UPDATE produkter
					SET Pnavn = '$Pnavn', Pbeskrivelse = '$Pbeskrivelse', Ppris = '$Ppris'
					WHERE produktID = '$produktID'";
									
		//-------------------------------------------
		//SQL: Skriver til database
		//-------------------------------------------
		if ($conn->query($sqlEditP) === TRUE) {
			$warning = "Oppdatert";
		}
	}

   	//------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------ FUNCTION --------------------------------------------------------------------
	//------------------------------------------------------------------------------------------------------------------------------------------
	//Slette produkt
	//------------------------------------------------------------------------------------------------------------------------------------------
	function slettProdukt($conn) {
		
		$produktID = $_REQUEST['produktID'];
		
		//-------------------------------------------
		//SQL: Slette produkt
		//-------------------------------------------
		$sqlD = "DELETE FROM produkter WHERE produktID='$produktID';";
		
		if ($conn->query($sqlD) === TRUE) {
			
		} else {
			echo "$sqlD";
		}
	}
?>

<script>
	//Get screen height
	var height = screen.height;
	height = height - 300;
			
	var sample = document.getElementById("main");
			
	sample.style.height = height + 'px';

//Prewies of Profile Image
 var loadFile = function(event) {
	var output = document.getElementById('profil');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
			URL.revokeObjectURL(output.src) // free memory
		}
	};
</script>

</div>