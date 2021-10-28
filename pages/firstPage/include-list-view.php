<div id='main'>
	<div id='list_container'>

	<?php
		//Henter Gårds/aktør info
		$sql = "SELECT tilbyderID, foretak_navn, om, adresse, postnummer, sted, land, fornavn, etternavn, tlf, epost FROM tilbydere WHERE godkjent=1";
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
			
			
			echo "<form action='index.php' method='get'>
					<input type='number' class='hidden' name='ysteriID' value='$tilbyderID'>
					<input type='number' class='hidden' name='tilbyderID' value='$tilbyderID'>";
			
			echo "
					<button class='bg-white row-list' name='action' value='ysteri'>
					
						<img srch='img/p/$tilbyderID.png' alt='profil bilde'>
						
						<div class='info'>
							<b>$foretak_navn</b>
							<p>$om</p>
						</div>
					</button>";
			echo "</form>";
		}
	?>
	</div>
</main>

<script>
	//Get screen height
	var height = screen.height;
	height = height - 295;
			
	var sample = document.getElementById("main");
			
	sample.style.height = height + 'px';
</script>