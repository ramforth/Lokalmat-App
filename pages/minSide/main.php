<?php
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- MIN SIDE ------------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
 	//-------------------------------------------
	//sjekker om brukeren er logget inn
	//-------------------------------------------
	
	if ($userID) {
		if ($action == 'slettfavotritt') {
			slettFav();
		}
		echo "
				<form class='flex-row' action='index.php' method='GET' style='margin-bottom: 15px;'>
					<div class='row-2 default'>
						<button class='fane'>Mine favoritter</button>
					</div>
					<div class='row-2 secondary' style='border-left-style: dotted; border-left-width: 1px;'>
						<button class='fane'>Brukeropplysninger</button>
					</div>
				</form>
				
				<div id='main'>
			";
			
		favoritterSkjema();
		
		echo "</div>";
	} else {
		echo "Du må ha en bruker og være logget inn for å se denne siden!";
	}
	
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 // -------------------------------------------------------- FUNKSJONER -----------------------------------------------------------
 /*-------------------------------------------------------------------------------------------------------------------------------*/
 
  	//-------------------------------------------
	//Favoritter liste /med skjema
	//-------------------------------------------
	
	function favoritterSkjema() {
		//-------------------------------------------
		//Henter database konfig
		//-------------------------------------------
		include "config/database.php";
		
		//-------------------------------------------
		//Henter bruker ID`en
		//-------------------------------------------
		$userID = $_COOKIE["userID"];
		
		
		//-------------------------------------------
		//Starter på selve Formen
		//-------------------------------------------
		echo "<form action='index.php' method='GET'>
				<input class='hidden' type='text' name='action' value='ysteri'>";
		
		//-------------------------------------------
		//SQL Spørring: Henter vavoritt ID
		//-------------------------------------------
		$sql = "SELECT favID, prodID, ysteriID FROM favoritter";
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)) {
			$favID = $row["favID"];
			$prodID = $row["prodID"];
			$ysteriID = $row["ysteriID"];
			
			//-------------------------------------------
			//SQL Spørring: For hver ID henter vi produkt
			//-------------------------------------------
			if ($prodID) {
				$sql_prod = "SELECT tilbyderID, Pnavn, Pbeskrivelse, Ppris FROM produkter WHERE produktID = $prodID";
				$result_prod = mysqli_query($conn, $sql_prod);

				while($row_prod = mysqli_fetch_assoc($result_prod)) {
					$tilbyderID = $row_prod["tilbyderID"];
					$Pnavn = $row_prod["Pnavn"];
					$Pbeskrivelse = $row_prod["Pbeskrivelse"];
					$Ppris = $row_prod["Ppris"];
					
					//-------------------------------------------
					//SQL Resultat
					//-------------------------------------------
					echo "
							<div class='bg-white row-list' style='border-bottom-style: solid; border-bottom-width: 1px; margin-bottom: 10px;'>
								<div class='flex-row'>
									<div class='column-2'>
										<img src='' alt='produkt bilde'>
									</div>
									<div class='flex-column'>
										<b>$Pnavn</b>
										<p><b>Pris: </b><i>$Ppris,-</i></p>
									</div>
								</div>
								
								<div>
									<p>$Pbeskrivelse</p>
								</div>
									
								
								<div class='flex-row'>
									<div class='column-1 default leftEdge' style='flex-grow: 1;'>
										<button class='fane' name='ysteriID' value='$tilbyderID'>Gå til Ysteri</button>
									</div>
									<div class='column-1 primarly rightEdge'>
										<form action='index.php' method='GET'>
											<input type='number' class='hidden' name='favID' value='$favID'>
											<button class='fane' name='action' value='slettfavotritt'>Fjern</button>
										</form>
									</div>
								</div>
							</div>";
				}
				
			} else if ($ysteriID) {
				$sql_yst = "SELECT tilbyderID, foretak_navn, om, adresse, postnummer, sted, land, tlf, epost FROM tilbydere WHERE tilbyderID = $ysteriID";
				$result_yst = mysqli_query($conn, $sql_yst);

				while($row_yst = mysqli_fetch_assoc($result_yst)) {
					$tilbyderID = $row_yst["tilbyderID"];
					$foretak_navn = $row_yst["foretak_navn"];
					$om = $row_yst["om"];
					$adresse = $row_yst["adresse"];
					$postnummer = $row_yst["postnummer"];
					$sted = $row_yst["sted"];
					$land = $row_yst["land"];
					$tlf = $row_yst["tlf"];
					$epost = $row_yst["epost"];
					
					//-------------------------------------------
					//SQL Resultat
					//-------------------------------------------
					echo "
							<div class='bg-white row-list' style='border-bottom-style: solid; border-bottom-width: 1px; margin-bottom: 10px;'>
								<div class='flex-row'>
									<div class='column-2'>
										<img src='' alt='Ystyeri bilde'>
									</div>
									<div class='flex-column'>
										<b>$foretak_navn</b>
									</div>
								</div>
								
								<div>
									<p>$om</p>
								</div>
								
								<div class='flex-row' style='height: 50px; margin-bottom: 5px;'>
									<div class='column-1' style='flex-grow: 1;'>
										<a class='call' href='tel:+47$tlf'>
											<div class='flex-row'>
												<img src='#' alt='mail_ico'>
												<b>Ring</b>
											</div>
										</a>
									</div>
									<div class='column-1'>
										<a class='mail' href='mailto:$epost'>
											<div class='flex-row'>
												<img src='#' alt='tel_ico'>
												<b>Send epost</b>
											</div>
										</a>
									</div>
								</div>								
								
								<div class='flex-row'>
									<div class='column-1 default leftEdge' style='flex-grow: 1;'>
										<button class='fane' name='ysteriID' value='$tilbyderID'>Se produkter</button>
									</div>
									<div class='column-1 primarly rightEdge'>
										<form action='index.php' method='GET'>
											<input type='number' class='hidden' name='favID' value='$favID'>
											<button class='fane' name='action' value='slettfavotritt'>Fjern</button>
										</form>
									</div>
								</div>
							</div>";
				}
			}
		}
	
		//-------------------------------------------
		//Avslutter web formen
		//-------------------------------------------
		echo "</form>";
	}
	
  	//-------------------------------------------
	//SLette ifra favoritt funksjon
	//-------------------------------------------
	function slettFav() {
		
		//-------------------------------------------
		//Henter database konfig
		//-------------------------------------------
		include "config/database.php";
		
		//-------------------------------------------
		//Henter bruker ID`en
		//-------------------------------------------
		$userID = $_COOKIE["userID"];

		//-------------------------------------------
		//Henter ID`en som skal slettes.
		//-------------------------------------------
		$favID = $_REQUEST['favID'];
		
		//-------------------------------------------
		//SQL Spørring: Henter vavoritt ID
		//-------------------------------------------
		$sql = "DELETE FROM favoritter WHERE favID='$favID';";
		
		if ($conn->query($sql) === TRUE) {
			echo "Fjernet ifra dine favoritter...";
		}
	}
?>

<script>
	//Get screen height
	var height = screen.height;
	height = height - 400;
			
	var sample = document.getElementById("main");
			
	sample.style.height = height + 'px';
</script>