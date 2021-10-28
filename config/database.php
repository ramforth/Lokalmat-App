<?php
	// Oppretter forbindelse til DB
		$conn = new mysqli('localhost', 'tronder', 'W8m3nx#9', 'lokalmat');
		
		$test = "Database fil er inkludert";

	// Sjekker forbindelse
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
?>