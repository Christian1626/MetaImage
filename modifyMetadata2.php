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

	<!-- Polymer -->
	<script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="import" href="bower_components/google-map/google-map.html">


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
			width: 300px;
		}
	</style>

</head>
<body>
<div class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-fixed-top .navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">MetaImage</a>
        </div>
        <!-- MENU -->
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
               <li><a href="info.html">A propos</a></li>
            </ul>
        </div>
    </div>
</div>
<?php

	function DMStoDEC($deg,$min,$sec,$dir)
	{

	// Converts DMS ( Degrees / minutes / seconds / direction ) 
	// to decimal format longitude / latitude
	    $res = $deg+((($min*60)+($sec))/3600);

	    if($dir == "S" || $dir == "W") {
	    	return -$res;
	    }

	    return $res;
	}  

	$imageName 	= $_GET['imageName'];

	//Si la modification est envoyée, on exec
	if (isset($_POST['EnvoyerModif']))
    {
		$param1='-Title="'.addcslashes($_POST['title_photo'], '"').'"';
		$param2='-IFD0:ImageDescription="'.addcslashes($_POST['ImageDescription'], '"').'"';
		$param3='-IPTC:Keywords="'.addcslashes($_POST['keywords'], '"').'"';
		$param4='-IFD0:Copyright="'.addcslashes($_POST['copyright'], '"').'"';
		$param5='-IFD0:Artist="'.addcslashes($_POST['artist'], '"').'"';

		$listeParam=$param1.' '.$param2.' '.$param3.' '.$param4.' '.$param5.' img/'.$imageName;
		//echo 'exiftool '.$listeParam;
		shell_exec('exiftool '.$listeParam);
    }

	$str = shell_exec('exiftool -json -g1 img/'.$imageName);
	$data=json_decode($str, true);
	$data = $data[0];
	
	/*echo "<pre>";
	print_r($data);
	echo "</pre>";*/

	$latitude = explode(" ",$data['Composite']['GPSLatitude']);
	$latitude = DMStoDEC($latitude[0],str_replace("'","",$latitude[2]),str_replace("\"","",$latitude[3]),$latitude[4]);

	$longitude = explode(" ",$data['Composite']['GPSLongitude']);
	$longitude = DMStoDEC($longitude[0],str_replace("'","",$longitude[2]),str_replace("\"","",$longitude[3]),$longitude[4]);
		
	//echo $latitude;
	//echo $longitude;
	$listeKW = "";
	
	if (is_array($data['IPTC']['Keywords'])){
		foreach($data['IPTC']['Keywords'] as $value ) {
			if($listeKW == "") {
				$listeKW = $listeKW . $value ;
			}
			else {
				$listeKW = $listeKW . ', '.  $value ;
			}
		}
	}else{
		$listeKW=$data['IPTC']['Keywords'];
	}

	echo '<div class="centrer">
			<h1>Modification de "'.$imageName.'" :</h1>
			<img src="img/'.$imageName.'" alt="Modifier L\'image courante" class="img-thumbnail" size="5em">
		</div><br/><br/>';

	
	
	echo '<div class="container">
	  <form class="form-horizontal" role="form" method="post">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="filename">Title:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="title_photo" name="title_photo" value="'.$data['XMP-dc']['Title'].'" >
		  </div>
		</div>

		 <div class="form-group">
		  <label class="control-label col-sm-2" for="description">Description:</label>
		  <div class="col-sm-10">
			<textarea class="form-control custom-control" rows="3" style="resize:none" name="ImageDescription">'.$data['IFD0']['ImageDescription'].'</textarea>     
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="keywords">Keywords:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="keyword" name="keywords" value="'.$listeKW.'" >
		  </div>
		</div>

		<div class="form-group">
		  <label class="control-label col-sm-2" for="copyright">Copyright:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="copyright" name="copyright" value="'.$data['IFD0']['Copyright'].'" >
		  </div>
		</div>

		 <div class="form-group">
		  <label class="control-label col-sm-2" for="artist">Artist:</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" id="artist" name="artist" value="'.$data['IFD0']['Artist'].'" >
		  </div>
		</div>



		<div class="form-group">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-warning" name="EnvoyerModif" onclick="return confirm(\'Appliquer définitivement les modifications aux metadatas de :\n '.$imageName.' ?\')">Modifier</button>
		  </div>
		</div>
	  </form>
	</div>';

	if (!empty($latitude) && !empty($longitude)) {
		echo '  <google-map latitude="37.77493" longitude="-122.41942" fit-to-markers>
	 	 <google-map-marker latitude="'.$latitude.'" longitude="'.$longitude.'"></google-map-marker>
		</google-map>';
	}
?>



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>
<script src="js/demo.js"></script>
</body>
</html>
