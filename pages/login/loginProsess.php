<?php
	//Henter Gårds/aktør info
		$sql = "SELECT userID FROM users WHERE email='$email' AND pw='$pw'";
		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result)) {
			$userID = $row["userID"];
			
			//Lager en cookie for å skjønne at brukeren er innlogget.
			
			setcookie("userID", $userID, time() + (86400 * 30 * 365), "/"); // 1 år
			
			setcookie("email", $email, time() + (86400 * 30 * 365), "/"); // 1 år
			setcookie("pw", $pw, time() + (86400 * 30 * 365), "/"); // 1 år
			
			$warning = "Du er innlogget.";
		}
		
		if (!$userID) {
			echo "<p>Feil brukernavn eller passord</p>";
			
			loginScema();
		} else {
			echo "<p>Du er logget inn</p>";
			$warning = "Du er logget inn";
			
			loginSucsess();
		}
?>