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
<div class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-fixed-top .navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="https://github.com/blueimp/Bootstrap-Image-Gallery">MetaImage</a>
        </div>
        <!-- MENU -->
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
               <li><a href="#">Upload Image</a></li>
               <li><a href="info.html">A propos</a></li>
            </ul>
        </div>
    </div>
</div>
<?php
	$imageName 	= $_GET['imageName'];

	//Si la modification est envoyée, on exec
	if (isset($_POST['EnvoyerModif']))
    {
		$param1='-Title="'.$_POST['title_photo'].'"';
		$param2='-IFD0:ImageDescription="'.$_POST['ImageDescription'].'"';
		$param3='-IPTC:Keywords="'.$_POST['keywords'].'"';
		$param4='-IFD0:Copyright="'.$_POST['copyright'].'"';
		$param5='-IFD0:Artist="'.$_POST['artist'].'"';

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

	
	//action="https://21101130.users.info.unicaen.fr/MetaImage/index.php"
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
			<textarea class="form-control custom-control" rows="3" style="resize:none">'.$data['IFD0']['ImageDescription'].'</textarea>     
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
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="js/bootstrap-image-gallery.js"></script>
<script src="js/demo.js"></script>
</body>
</html>
