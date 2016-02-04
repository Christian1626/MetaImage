

<!DOCTYPE HTML>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Modification des Metadata</title>

	<meta name="description" content="Outil de modification des metadata de l'image.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="css/bootstrap-image-gallery.css">
	<link rel="stylesheet" href="css/demo.css">
	<link href='https://fonts.googleapis.com/css?family=Lobster|Pacifico|Dosis|Oswald' rel='stylesheet' type='text/css'>
	<!-- Polymer -->
	<script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="import" href="bower_components/google-map/google-map.html">

	<?php include("src/function_modify.php"); ?>
	<?php include("src/flickr.php"); ?>

	<?php
		$imageName 	= $_GET['imageName'];

   		 //exécute EXIF
		$data = getMetadata($imageName);

		//METADATA
		openGraph($data);
		twitterCards($data);
	?>


	<style media="screen" type="text/css">
		.img-thumbnail{
			max-height: 20em;
		}
		.centrer{
			margin : auto;
			text-align : center;
		}
		google-map {
			height: 300px;
			width: 95%;
		}

		h3 {
		    font-family: 'Oswald', sans-serif !important;
		    color: #FFC274 !important;
		}
	</style>

</head>
<body>
<?php include("src/navigation-bar.php"); ?>




<?php

	///////////////////////////////////////////////////////
	//                   MODIFICATION
	///////////////////////////////////////////////////////
	//Si la modification est envoyée, on exec
	if (isset($_POST['EnvoyerModif']))
    {
			modifyMetadata($data,$imageName);
    }
    ///////////////////////////////////////////////////////

    ?>






<?php
	///////////////////////////////////////////////////////
	//               AFFICHAGE DES METADATA
	///////////////////////////////////////////////////////

	//var_dump($data);

	$data = getMetadata($imageName);

	//Transforme les cordonnées GPS => DMS to DEC
	$latitude = getLatitude($data);
	$longitude = getLongiude($data);

	//echo "GPS: ".$latitude . " : " .$longitude;

	//Creer un tableau contenant les keyword de l'image
	$listeKW = getListKW($data);

	displayMetadata($imageName,$data,$listeKW,$latitude,$longitude);

	displayAllMetadata($data,$imageName);
	if(!empty($listeKW)) {
		displaySimilarPicture($latitude, $longitude, $listeKW);
	}
?>




<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>
</body>
</html>
