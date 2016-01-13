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


	<style media="screen" type="text/css">
	.img-thumbnail{
		max-height: 20em;
	}
	.centrer{
		margin : auto;
		text-align : center;
	}
	</style>

</head>
<body>
<?php

	//$img 		= $_POST['imageSelected'];
	//$name 		= $_POST['imageName'];
	$imageNameTmp 	= 'img/photo1.jpg';

	echo '<div class="centrer">
			<h1>Modification de "'.$imageNameTmp.'" :</h1>
			<img src="'.$imageNameTmp.'" alt="Modifier L\'image courante" class="img-thumbnail" size="5em">
		</div>
		<fieldset>
			<legend>Modification des metadata de l\'image :</legend>
 			<form class ="form-horizontal" action="TODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO" method="post">';

	/*Liste des champs autorisés pour modification (non techniques) :
	keywords
	artiste
	title
	description
	credit
	copyright
	date ?
	location ?
	xmp headline
	*/

	/*
	FORM :
	Titre
	chapo
	description
	Mots-clés
	droits
	licence
	auteur

	COMPATIBILITE :
	JPG
	PNG
	*/

	$exif = exif_read_data($imageNameTmp, 0,true);
	echo $exif===false ? "Aucun en-tête de donnés n'a été trouvé.<br />\n" : "";
	foreach ($exif as $key => $section) {
		echo '<h2>'.$key.'</h2>';
	    foreach ($section as $name => $value) {
	    	//$exif_tab[$name] .= $value;
	        //echo "$key: $val<br />\n";
	        echo '
	        <div class="form-gourp">
	        	<label for="id_'.$name.'" class="col-sm-2 control-label">'.$name.'</label>
	        	<div class="col-sm-10">
	        		<input type="text" id="id_"'.$name.'" class="form-control" value="'.$value.'" />
	        	</div>
	        </div>';
	    }
	}
	?>
 <input type="submit" value="Envoyer"> <input type="reset">
 </form>
</fieldset>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>
<script src="js/demo.js"></script>
</body>
</html>
