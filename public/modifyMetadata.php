
<?php 
define('ROOT', dirname(__DIR__)); 
//require ROOT.'app/Flickr.php';
require_once ROOT.'/app/Image.php';
require_once ROOT.'/app/Json.php';
require_once ROOT.'/app/ExifTool.php';
?>

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
	<script src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="import" href="../bower_components/google-map/google-map.html">

	<?php
		extract($_GET);
		$image = new Image($imageName);
		//var_dump($image); //TODO : A DELETE

		//Affiche les metadata, twittercard et opengraph de l'image,
		require ROOT.'/app/Views/metadataImage.php';
	?>
</head>



<body>
<!-- Navbar -->
<?php require ROOT.'/app/Views/navigation-bar.php'; ?>



<?php

	///////////////////////////////////////////////////////
	//                   MODIFICATION
	///////////////////////////////////////////////////////
	//var_dump($image);
	if (isset($_POST['EnvoyerModif']))
    {
    	//TODO 
    	$image->modifyMetadata();
    	$image = new Image($imageName);
		//var_dump($image);
    }

	///////////////////////////////////////////////////////
	//               AFFICHAGE DES METADATA
	///////////////////////////////////////////////////////
	require ROOT.'/app/Views/displayImage.php';
?>


<div class="container">
	<h3> Images similaires via Flickr  </h3>
	<div class='loading'>
	  <div class='loader'>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--text'></div>
	  </div>
	</div>
</div>

<div id="flickrGallery"> </div>



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>

<script>
$(function() {
	var keywords = $('#keyword').val();
	var title = $('#title_photo').val();

	var query = keywords ? keywords: title;

	if(query) {
		 $('#flickrGallery').load("ajax/flickrGallery.php",{query:query},function() {
		 	$(".loading").fadeOut("slow");
		 });
	}
   
});
</script>
</body>
</html>
