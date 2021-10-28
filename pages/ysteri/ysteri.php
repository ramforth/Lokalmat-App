<?php
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- YSTERI --------------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
  	//-------------------------------------------
	//lagrer favoritt
	//-------------------------------------------
	
	if ($userAction == 'hearth' AND $userID) {
		lagreYsteriFavoritt();
	} else if ($userAction == 'removeHearth' AND $userID) {
		removeHearth();
	}
 
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- DATABASE ------------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
 //Henter Gårds/aktør info
	$sql = "SELECT tilbyderID, foretak_navn, om, adresse, postnummer, sted, land, fornavn, etternavn, tlf, epost FROM tilbydere WHERE tilbyderID='$ysteriID'";
	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result)) {
		$tilbyderID = $row["tilbyderID"];
		$foretak_navn = $row["foretak_navn"];
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
?>

<div id='flex-column'>
	<!-- Øverste seksjon -->
	<div class='flex-column muted center'>
		<div class='flex-row' style='align-items: center;'>
			<div class='row-1' style='flex-shrink: 10; width: 30px;'></div>
			<h3 class='row-1 center' style='flex-grow: 10;'><?php echo "$foretak_navn"; ?></h3>
			
			<!-- Harth ico -->
			<?php include "hearth_ico.php"; ?>
		</div>
		
		<img class='mainImg' srch='<?php echo "img/example_image.png"; ?>' alt='Bilde av Ysteriet'>
		
		<b class='row-1 center'>Beskrivelse:</b>
		<p class='row-1'><?php echo "$om"; ?></p>
	</div>
	
	<!-- Midt seksjon -->
	<div class='flex-row secondary mp5'>
		<button class='column-2'>Navigasjon</button>
		<button class='column-2'>Ring</button>
	</div>
	
	<!-- nedre seksjon -->
	<div id='main'>
		<div class='flex-column primarily'>
			
			<?php
				/*---------------------------------------------------------------------------------------------*/
				//-------------------------------------- SQL ---------------------------------------------------
				/*---------------------------------------------------------------------------------------------*/
				
				//Henter produktene
				$sql_p = "SELECT produktID, Pnavn, Pbeskrivelse, Ppris FROM produkter WHERE tilbyderID='$ysteriID'";
				$result_p = mysqli_query($conn, $sql_p);
				
				while($row_p = mysqli_fetch_assoc($result_p)) {
					$produktID = $row_p["produktID"];
					$Pnavn = $row_p["Pnavn"];
					$Pbeskrivelse = $row_p["Pbeskrivelse"];
					$Ppris = $row_p["Ppris"];
					
					echo "
							<div class='row-list bg-white flex-column mp5'>
								<div class='flex-row'>
									<img class='column-2' srch='img/produkter/$produktID.png' alt='Bilde av et produkt'>
									
									<div class='column-2 flex-column'>
										<b class='column-2'>$Pnavn</b>
										<i class='column-2 price'>Pris: $Ppris,-</i>
									</div>
								</div>
								
								<p class='column-1 produktBeskrivelse'>$Pbeskrivelse</p>
							</div>
					";
				}
			?>
		</div>
	</div>
</div>
<?php
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- FUNKSJONER -----------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
  	//-------------------------------------------
	//lagrer favoritt
	//-------------------------------------------
	
	function lagreYsteriFavoritt() {

		//-------------------------------------------
		//Henter database konfig
		//-------------------------------------------
		include "config/database.php";
		
		//-------------------------------------------
		//Henter bruker ID`en
		//-------------------------------------------
		$userID = $_COOKIE["userID"];
		
		//-------------------------------------------
		//Henter ysteri ID
		//-------------------------------------------
		$ysteriID = $_REQUEST['ysteriID'];
		
		//-------------------------------------------
		//SQL
		//-------------------------------------------
		
		$sql = "INSERT INTO favoritter (favID, userID, prodID, ysteriID)
					VALUES ('', '$userID', '', '$ysteriID')";
									
		//Skriver til database
		if ($conn->query($sql) === TRUE) {
				
		}
	}
	
  	//-------------------------------------------
	//Slette favoritt
	//-------------------------------------------
	function removeHearth() {
		
		//-------------------------------------------
		//Henter database konfig
		//-------------------------------------------
		include "config/database.php";
		
		//-------------------------------------------
		//Henter bruker ID`en
		//-------------------------------------------
		$userID = $_COOKIE["userID"];
		
		//-------------------------------------------
		//Henter ysteri ID
		//-------------------------------------------
		$ysteriID = $_REQUEST['ysteriID'];
		
		//-------------------------------------------
		//SQL henter favoritt ID
		//-------------------------------------------
		$sql2 = "SELECT favID, prodID, ysteriID FROM favoritter WHERE ysteriID='$ysteriID'";
		$result2 = mysqli_query($conn, $sql2);

		while($row2 = mysqli_fetch_assoc($result2)) {
			$favID = $row2["favID"];
		}
		
		//-------------------------------------------
		//SQL henter favoritt ID
		//-------------------------------------------
		$sql = "DELETE FROM favoritter WHERE favID='$favID';";
		
		if ($conn->query($sql) === TRUE) {

		}
	}
?>
<script>
	//Get screen height
	var height = screen.height;
	height = height - 510;
			
	var sample = document.getElementById("main");
			
	sample.style.height = height + 'px';
</script>