<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Lokalmat</title>
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1, initial-scale = 1.0, shrink-to-fit=no">
	</head>
	
	<style>
		body, html {
			margin: 0px;
			display: flex;
			flex-direction: column;
			height: 100%;
		}
		
		header {
			background-color: red;
			height: 100px;
		}
		
		#main {
			background-color: blue;
			flex-grow: 4;
			overflow: scroll;
		}
		
		div.footer {
			background-color: yellow;
			height: 100px;
		}
		
		#output {
			display: block;
			width: 150px;
			height: auto;
			margin-left: auto;
			margin-right: auto;
		}
	</style>
	
	<body>
		<header>
			<h1>Header</h1>
		</header>
		
		<div id='main'>
			<h3>Bilde opplasnings prosjekt</h3>
			<?php
				//Standarder
				$userID = '1';
				$tilbyderID = '1';
				
				if(isset($_POST['upload'])){
					echo "Debug: starting upload prosess.... <br />";
					
				  // Getting file name
				  $filename = $_FILES['imagefile']['name'];
				 
				  // Valid extension
				  $valid_ext = array('png','jpeg','jpg');

				  // Location
				  $location = "img/test/".$filename;

				  // file extension
				  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
				  $file_extension = strtolower($file_extension);

				  // Check extension
				  if(in_array($file_extension,$valid_ext)){

					// Compress Image
					compressImage($_FILES['imagefile']['tmp_name'],$location,60);

				  }else{
					echo "Invalid file type.";
				  }
				}

				// Compress image
				function compressImage($source, $destination, $quality) {

				  $info = getimagesize($source);

				  if ($info['mime'] == 'image/jpeg') 
					$image = imagecreatefromjpeg($source);

				  elseif ($info['mime'] == 'image/gif') 
					$image = imagecreatefromgif($source);

				  elseif ($info['mime'] == 'image/png') 
					$image = imagecreatefrompng($source);

				  imagejpeg($image, $destination, $quality);

				}
			?>
			
			<form method='POST' action='flex.php' enctype='multipart/form-data'>
				<input type="file" name='imagefile' accept="image/*" onchange="loadFile(event)">
				<img id="output"/>
				
				<button name='upload' value='upload'>Upload</button>
			</form>
			
			<script>
			  var loadFile = function(event) {
				var output = document.getElementById('output');
				output.src = URL.createObjectURL(event.target.files[0]);
				output.onload = function() {
				  URL.revokeObjectURL(output.src) // free memory
				}
			  };
			</script>
		</div>
		
		<script>
			//Get screen height
			var height = screen.height;
			height = height - 350;
			
			var sample = document.getElementById("main");
			sample.style.color = 'red';
			
			sample.style.height = height + 'px';
		</script>
		
		<div class='footer'>
			<b>Footer</b>
		</div>
	</body>
	
</head>