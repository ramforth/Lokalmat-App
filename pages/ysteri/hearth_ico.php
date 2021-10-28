<?php
	//Sjekker om Ysteriet allerede er en favoritt
	$sql2 = "SELECT favID, prodID, ysteriID FROM favoritter WHERE ysteriID='$ysteriID' AND userID='$userID'";
	$result2 = mysqli_query($conn, $sql2);

	while($row2 = mysqli_fetch_assoc($result2)) {
		$favID = $row2["favID"];
	}
	
	if ($favID) {
		
			echo "
				<form id='harth' class='row-1' style='flex-shrink: 10;' action='index.php' method='get'>
					<button>
						<input type='text' class='hidden' name='action' value='ysteri'>
						<input type='text' class='hidden' name='userAction' value='removeHearth'>
						<input type='text' class='hidden' name='ysteriID' value='$tilbyderID'>
						<img src='img/ico/hearth_ico_2.png' alt='hearth ico'>
					</button>
				</form>
				";
	} else {
			echo "
				<form id='harth' class='row-1' style='flex-shrink: 10;' action='index.php' method='get'>
					<button>
						<input type='text' class='hidden' name='action' value='ysteri'>
						<input type='text' class='hidden' name='userAction' value='hearth'>
						<input type='text' class='hidden' name='ysteriID' value='$tilbyderID'>
						<img src='img/ico/hearth_ico_1.png' alt='hearth ico'>
					</button>
				</form>
				";
	}
?>